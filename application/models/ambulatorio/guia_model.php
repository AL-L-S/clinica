<?php

class guia_model extends Model {

    var $_ambulatorio_guia_id = null;
    var $_nome = null;

    function guia_model($ambulatorio_guia_id = null) {
        parent::Model();
        if (isset($ambulatorio_guia_id)) {
            $this->instanciar($ambulatorio_guia_id);
        }
    }

    function listarpaciente($paciente_id) {

        $this->db->select('nome,
                            telefone
                            ');
        $this->db->from('tb_paciente');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarpacientes($parametro = null) {

        $this->db->select('paciente_id,
                            nome');
        $this->db->from('tb_paciente');
        $this->db->where('ativo', 't');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listar($paciente_id) {

        $this->db->select('ag.ambulatorio_guia_id,
                            ag.paciente_id,
                            ag.empresa_id,
                            ag.data_cadastro,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->where("ag.paciente_id", $paciente_id);
        $this->db->orderby('ag.ambulatorio_guia_id', 'desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexames($paciente_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.faturado,
                            ae.agenda_exames_nome_id,
                            ae.ativo,
                            ae.situacao,
                            ae.cancelada,
                            e.exames_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            ae.guia_id,
                            e.situacao as situacaoexame,
                            al.situacao as situacaolaudo,
                            ae.paciente_id,
                            c.dinheiro,
                            ae.recebido,
                            ae.data_recebido,
                            ae.empresa_id,
                            emp.nome as empresa,
                            ae.empresa_id,
                            ae.entregue,
                            ae.data_entregue,
                            p.nome as paciente,
                            p.indicacao,
                            p.nascimento,
                            ae.entregue_telefone,
                            o.nome as operadorrecebido,
                            op.nome as operadorentregue,
                            oz.nome as atendente,
                            om.nome as medicorealizou,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            ae.data_antiga
                            ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id= pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_empresa emp', 'emp.empresa_id = ae.empresa_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_recebido', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_entregue', 'left');
        $this->db->join('tb_operador om', 'om.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_operador oz', 'oz.operador_id = ae.operador_autorizacao', 'left');
        $this->db->where('ae.confirmado', 't');
//        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where("ae.paciente_id", $paciente_id);
        $this->db->orderby('ae.guia_id');
        $this->db->orderby('ae.agenda_exames_id');
        $return = $this->db->get();
        return $return->result();
    }

    function vizualizarobservacoes($agenda_exame_id) {
        $this->db->select('entregue_observacao');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exame_id);
        $return = $this->db->get();
        return $return->result();
    }

    function vizualizarpreparo($tuss_id) {
        $this->db->select('texto');
        $this->db->from('tb_tuss');
        $this->db->where('tuss_id', $tuss_id);
        $return = $this->db->get();
        return $return->result();
    }

    function vizualizarpreparoconvenio($convenio_id) {
        $this->db->select('observacao as texto');
        $this->db->from('tb_convenio');
        $this->db->where('convenio_id', $convenio_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarchamadas() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ac.ambulatorio_chamada_id,
                            ac.descricao,
                            p.nome as paciente,
                            es.nome_chamada as sala,
                            es.nome as nome_sala');
        $this->db->from('tb_ambulatorio_chamada ac');
        $this->db->join('tb_paciente p', 'p.paciente_id = ac.paciente_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ac.sala_id', 'left');
        $this->db->where('ac.empresa_id', $empresa_id);
        $this->db->where("ac.ativo", 'true');
        $this->db->limit(1);
        $query = $this->db->get();
        $return = $query->result();

        $ambulatorio_chamada_id = $return[0]->ambulatorio_chamada_id;

        $this->db->set('ativo', 'f');
        $this->db->where('ambulatorio_chamada_id', $ambulatorio_chamada_id);
        $this->db->update('tb_ambulatorio_chamada');


        return $return;
    }

    function relatorioexamesconferencia() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.autorizacao,
                            pc.qtdech,
                            pc.valorch,
                            ae.paciente_id,
                            o.nome as medico,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            pt.grupo,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['grupoconvenio'] != "0") {
            $this->db->where("c.convenio_grupo_id", $_POST['grupoconvenio']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['faturamento'] != "0") {
            $this->db->where("ae.faturado", $_POST['faturamento']);
        }
        if ($_POST['tipo'] != "0" && $_POST['tipo'] != "" && $_POST['tipo'] != "-1") {
            $this->db->where("tu.classificacao", $_POST['tipo']);
        }
        if ($_POST['tipo'] == "") {
            $this->db->where("tu.classificacao in (2,3)");
        }
        if ($_POST['tipo'] == "-1") {
            $this->db->where("tu.classificacao in (1,2)");
        }
        if ($_POST['raca_cor'] != "0" && $_POST['raca_cor'] != "-1") {
            $this->db->where('p.raca_cor', $_POST['raca_cor']);
        }
        if ($_POST['raca_cor'] == "-1") {
            $this->db->where('p.raca_cor !=', '5');
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['procedimentos'] != "0") {
            $this->db->where('pt.procedimento_tuss_id', $_POST['procedimentos']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
            $this->db->where('pt.grupo !=', 'TOMOGRAFIA');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('c.convenio_id');
        if ($_POST['classificacao'] == "0") {
            $this->db->orderby('ae.guia_id');
            $this->db->orderby('ae.data');
            $this->db->orderby('p.nome');
        } else {
            $this->db->orderby('p.nome');
            $this->db->orderby('ae.guia_id');
            $this->db->orderby('ae.data');
        }
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesala() {

        $this->db->select('an.nome, count(an.nome) as quantidade, sum(ae.valor_total) as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['salas'] != "0") {
            $this->db->where("ae.agenda_exames_nome_id", $_POST['salas']);
        }
        $this->db->groupby('an.nome');
        $this->db->orderby('an.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexames() {

        $this->db->select('p.paciente_id,
                            p.nome as paciente,
                            p.data_cadastro,
                            c.nome as convenio,
                            p.nascimento');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->where("p.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("p.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("p.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        $this->db->orderby('c.convenio_id');
        $this->db->orderby('p.nome');
        $this->db->orderby('p.data_cadastro');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamescontador() {

        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriocancelamento() {

        $this->db->select('ac.agenda_exames_id,
                            ac.data_cadastro as data,
                            ac.operador_cadastro,
                            o.nome as operador,
                            c.nome as convenio,
                            ac.paciente_id,
                            ae.data_autorizacao,
                            ac.observacao_cancelamento,
                            p.nome as paciente,
                            ac.procedimento_tuss_id,
                            pt.nome as exame,
                            pt.grupo,
                            ca.descricao,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_ambulatorio_atendimentos_cancelamento ac');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = ac.agenda_exames_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ac.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ac.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_ambulatorio_cancelamento ca', 'ca.ambulatorio_cancelamento_id = ac.ambulatorio_cancelamento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ac.operador_cadastro', 'left');
        $this->db->where("ac.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
        $this->db->where("ac.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ac.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('c.convenio_id');
        $this->db->orderby('ac.data_cadastro');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocancelamentocontador() {

        $this->db->select('ac.agenda_exames_id');
        $this->db->from('tb_ambulatorio_atendimentos_cancelamento ac');
        $this->db->join('tb_paciente p', 'p.paciente_id = ac.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ac.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ac.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
        $this->db->where("ac.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ac.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriovalorprocedimento() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.valor,
                            ae.situacao,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.autorizacao,
                            ae.paciente_id,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.empresa_id', $_POST['empresa']);
        $this->db->where("ae.procedimento_tuss_id", $_POST['procedimento1']);
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriovalorprocedimentocontador() {

        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.empresa_id', $_POST['empresa']);
        $this->db->where("ae.procedimento_tuss_id", $_POST['procedimento1']);
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatorioexamesgrupo() {

        $this->db->select('pt.grupo,
            c.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.grupo');
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesgrupoprocedimento() {

        $this->db->select('pt.nome,
            c.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.procedimento_tuss_id');
        $this->db->groupby('pt.nome');
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesgrupoprocedimentoacompanhamento() {

        $this->db->select('pt.nome,
            c.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.procedimento_tuss_id');
        $this->db->groupby('pt.nome');
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriogrupoprocedimentomedico() {

        $this->db->select('pt.nome,
            c.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medico'] != "0") {
            $this->db->where("al.medico_parecer1", $_POST['medico']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.procedimento_tuss_id');
        $this->db->groupby('pt.nome');
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesgrupoanalitico() {

        $this->db->select('pt.grupo,
            c.nome as convenio,
            ae.quantidade,
	    p.nome,
	    pt.nome as procedimento,
            ae.valor_total as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime($_POST['txtdata_inicio'])));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime($_POST['txtdata_fim'])));
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ae.data');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesgrupocontador() {

        $this->db->select('pt.grupo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] != "0") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.grupo');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatorioexamesfaturamentorm() {

        $this->db->select('pt.grupo,
            c.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->where('pt.grupo', 'RM');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.grupo');
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesfaturamentormcontador() {

        $this->db->select('pt.grupo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->where('pt.grupo', 'RM');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pt.grupo');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriogeralconvenio() {

        $this->db->select('c.nome as convenio,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        // $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioresumogeralconvenio() {

        $this->db->select('c.nome as convenio,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriogeralconveniocontador() {

        $this->db->select('c.nome');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['convenio'] == "-1") {
            $this->db->where("c.dinheiro", "t");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('c.nome');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicosolicitante() {

        $this->db->select('o.nome as medico,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicosolicitantecontador() {

        $this->db->select('o.nome as medico,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicosolicitantexmedico() {

        $this->db->select('o.nome as medicosolicitante,
            os.nome as medico,
            pt.nome as procedimento,
            p.nome as paciente,
            ae.valor_total as valor,
            al.situacao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador os', 'os.operador_id = al.medico_parecer1', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicosolicitantecontadorxmedico() {

        $this->db->select('o.nome as medicosolicitante');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicosolicitantexmedicoindicado() {

        $this->db->select('o.nome as medicosolicitante,
            os.nome as medico,
            pt.nome as procedimento,
            p.nome as paciente,
            ae.valor_total as valor,
            al.situacao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador os', 'os.operador_id = al.medico_parecer1', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.indicado', 't');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicosolicitantecontadorxmedicoindicado() {

        $this->db->select('o.nome as medicosolicitante');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.indicado', 't');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriolaudopalavra() {

        $this->db->select('os.nome as medico,
            pt.nome as procedimento,
            p.nome as paciente,
            p.telefone,
            tl.descricao as tipologradouro,
            p.logradouro,
            p.numero,
            p.complemento,
            p.bairro,
            p.nascimento,
            p.sexo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_tipo_logradouro tl', 'tl.tipo_logradouro_id = p.tipo_logradouro', 'left');
        $this->db->join('tb_operador os', 'os.operador_id = al.medico_parecer1', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('al.texto ilike', "%" . $_POST['palavra'] . "%");
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriolaudopalavracontador() {

        $this->db->select('o.nome as medicosolicitante');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('al.texto ilike', "%" . $_POST['palavra'] . "%");
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicosolicitanterm() {

        $this->db->select('o.nome as medico,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where('pt.grupo', 'RM');
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicosolicitantecontadorrm() {

        $this->db->select('o.nome as medico,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where('pt.grupo', 'RM');
        if ($_POST['medicos'] != "0") {
            $this->db->where('o.operador_id', $_POST['medicos']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicoconvenio() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.autorizacao,
            ae.data,
            ae.valor_total,
            pc.procedimento_tuss_id,
            al.medico_parecer1,
            pt.perc_medico,
            pt.grupo,
            al.situacao as situacaolaudo,
            o.nome as revisor,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data_realizacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:01");
        $this->db->where("ae.data_realizacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        $this->db->orderby('c.nome');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');


        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniocontador() {

        $this->db->select('ae.data,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data_realizacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:01");
        $this->db->where("ae.data_realizacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriotecnicoconvenio() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.data,
            pt.grupo,
            o.nome as tecnico,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['tecnicos'] != "0") {
            $this->db->where('e.tecnico_realizador', $_POST['tecnicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('o.nome');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioindicacao() {

        $this->db->select('p.nome as paciente,
            pi.nome as indicacao');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao');
        $this->db->join('tb_agenda_exames ae', 'ae.paciente_id = p.paciente_id');

        if ($_POST['indicacao'] != "0") {
            $this->db->where("p.indicacao", $_POST['indicacao']);
        } else {
            $this->db->where("p.indicacao is not null");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('pi.nome');
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorionotafiscal() {
        $inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));

        $this->db->select('distinct(g.ambulatorio_guia_id ),
                            data_criacao,
                            g.valor_guia,
                            sum(ae.valor_total) as total,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_guia g');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = g.paciente_id', 'left');
        $this->db->where('g.nota_fiscal', 't');
        $this->db->where('ae.empresa_id', '1');
        $this->db->where('ae.data >=', $inicio);
        $this->db->where('ae.data <=', $fim);
        $this->db->groupby('g.ambulatorio_guia_id');
        $this->db->groupby('p.nome');
        $this->db->orderby('p.nome');

        $return = $this->db->get();
        return $return->result();
    }

    function relatorioindicacaoconsolidado() {

        $this->db->select('pi.nome as indicacao,
            count(pi.nome) as quantidade');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao');
        $this->db->join('tb_agenda_exames ae', 'ae.paciente_id = p.paciente_id');
        if ($_POST['indicacao'] != "0") {
            $this->db->where("p.indicacao", $_POST['indicacao']);
        } else {
            $this->db->where("p.indicacao is not null");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('pi.nome');
        $this->db->orderby('pi.nome');
//        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriovalormedio() {

        $this->db->select('pt.nome as procedimento,
                            count(pt.nome) as quantidade,
                            sum(valortotal) as valor,');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('pt.nome');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriovalormedioconvenio() {

        $this->db->select('pt.nome as procedimento,
                            pt.procedimento_tuss_id,
                            c.nome as convenio,
                            pc.valortotal');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('c.convenio_id');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriograficoalormedio($procedimento) {

        $this->db->select('pt.nome as procedimento,
                            pt.procedimento_tuss_id,
                            c.nome as convenio,
                            pc.valortotal');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_procedimento_convenio pc', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pt.procedimento_tuss_id', $procedimento);
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriograficovalormedio2($procedimento, $convenio, $txtdata_inicio, $txtdata_fim) {

        $txtdatainicio = str_replace("-", "/", $txtdata_inicio);
        $txtdatafim = str_replace("-", "/", $txtdata_fim);
//        var_dump($txtdatainicio);
//        var_dump($txtdatafim);
//        die;
        $this->db->select('count(pt.nome) as quantidade');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("ae.data >=", $txtdatainicio);
        $this->db->where("ae.data <=", $txtdatafim);
        $this->db->where('pt.procedimento_tuss_id', $procedimento);
        $this->db->where('c.nome', $convenio);
        $this->db->groupby('pt.nome');
        $this->db->orderby('pt.nome');
        $return = $this->db->get();
        $result = $return->result();

        if (isset($result[0]->quantidade)) {
            $qua = $result[0]->quantidade;
            $quantidade = (int) $qua;
        } else {
            $quantidade = 0;
        }
        return $quantidade;

//        $quantidade = count($result);
//        $this->db->select('pt.nome as procedimento,
//                            pt.procedimento_tuss_id,
//                            c.nome as convenio,
//                            pc.valortotal');
//        $this->db->from('tb_convenio c');
//        $this->db->join('tb_procedimento_convenio pc', 'pc.convenio_id = c.convenio_id', 'left');
//        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
//        $this->db->where('pc.ativo', 'true');
//        $this->db->where('pt.procedimento_tuss_id', $procedimento);
//        $this->db->where('c.nome', $convenio);
//        $this->db->orderby('c.nome');
//        $return = $this->db->get();
//        $result=$return->result();
//        $quantidade=  count($result);
//        return $quantidade;
    }

    function relatoriotecnicoconveniocontador() {

        $this->db->select('ae.data,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['tecnicos'] != "0") {
            $this->db->where('e.tecnico_realizador', $_POST['tecnicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriotecnicoconveniosintetico() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.data,
            pt.grupo,
            o.nome as tecnico,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['tecnicos'] != "0") {
            $this->db->where('e.tecnico_realizador', $_POST['tecnicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('e.tecnico_realizador');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');


        $return = $this->db->get();
        return $return->result();
    }

    function relatoriotecnicoconveniocontadorsintetico() {

        $this->db->select('ae.data,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['tecnicos'] != "0") {
            $this->db->where('e.tecnico_realizador', $_POST['tecnicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioexamesatendidos() {
        $data = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio,
                            l.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');



        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));

        $this->db->where('ae.data <=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioexamesnaoatendidos() {
        $data = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');



        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));

        $this->db->where('ae.data <=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_agenda', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioexamesatendidosdatafim() {
        $data = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio,
                            l.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');
        $this->db->where("ae.data >", $data);

        $this->db->where('ae.data <=', date("Y-m-d", strtotime($_POST['txtdata_fim'])));

        $this->db->where('ae.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioexamesnaoatendidosdatafim() {
        $data = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->where("ae.data >", $data);

        $this->db->where('ae.data <=', date("Y-m-d", strtotime($_POST['txtdata_fim'])));

        $this->db->where('ae.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_agenda', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioexamesatendidos2() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $empresa_id = $this->session->userdata('empresa_id');
        $datainicio = str_replace("/", "-", ($_POST['txtdata_inicio']));
        $datafim = str_replace("/", "-", ($_POST['txtdata_fim']));
        // EXAMES ATENDIDOS

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio,
                            l.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');


        $this->db->where('ae.data <=', $datafim);

        $this->db->where("ae.data >=", $datainicio);
        $this->db->where('ae.data <=', $datafim);

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioexamesnaoatendidos2() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $empresa_id = $this->session->userdata('empresa_id');
        $datainicio = str_replace("/", "-", ($_POST['txtdata_inicio']));
        $datafim = str_replace("/", "-", ($_POST['txtdata_fim']));

        // EXAMES ATENDIDOS
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');


        $this->db->where('ae.data <=', $datafim);

        $this->db->where("ae.data >=", $datainicio);
        $this->db->where('ae.data <=', $datafim);

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_agenda', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioconsultasatendidos() {
        $data = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio,
                            l.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');



        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));

        $this->db->where('ae.data <=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('pt.nome not ilike', '%RETORNO%');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioconsultasnaoatendidos() {
        $data = date("d/m/Y");
        $empresa_id = $this->session->userdata('empresa_id');
        // EXAMES ATENDIDOS
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');



        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));

        $this->db->where('ae.data <=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioconsultasatendidosdatafim() {
        $data = date("d-m-Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio,
                            l.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');
        $this->db->where("ae.data >", $data);

        $this->db->where('ae.data <=', date("Y-m-d", strtotime($_POST['txtdata_fim'])));

        $this->db->where('ae.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('pt.nome not ilike', '%RETORNO%');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioconsultasnaoatendidosdatafim() {
        $data = date("d/m/Y");
        $empresa_id = $this->session->userdata('empresa_id');

        // EXAMES ATENDIDOS
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->where("ae.data >", $data);

        $this->db->where('ae.data <=', date("Y-m-d", strtotime($_POST['txtdata_fim'])));

        $this->db->where('ae.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioconsultasatendidos2() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $empresa_id = $this->session->userdata('empresa_id');
        $datainicio = str_replace("/", "-", ($_POST['txtdata_inicio']));
        $datafim = str_replace("/", "-", ($_POST['txtdata_fim']));

        // EXAMES ATENDIDOS

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio,
                            l.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');


        $this->db->where('ae.data <=', $datafim);

        $this->db->where("ae.data >=", $datainicio);
        $this->db->where('ae.data <=', $datafim);

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('pt.nome not ilike', '%RETORNO%');
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconvenioconsultasnaoatendidos2() {
        $data['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $empresa_id = $this->session->userdata('empresa_id');
        $datainicio = str_replace("/", "-", ($_POST['txtdata_inicio']));
        $datafim = str_replace("/", "-", ($_POST['txtdata_fim']));

        // EXAMES ATENDIDOS
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            pc.valortotal,
                            pt.nome,
                            ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');


        $this->db->where('ae.data <=', $datafim);

        $this->db->where("ae.data >=", $datainicio);
        $this->db->where('ae.data <=', $datafim);

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'CONSULTA');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconsultaconvenio() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.autorizacao,
            ae.data,
            pt.grupo,
            al.situacao as situacaolaudo,
            o.nome as revisor,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.paciente_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioconsultaconveniocontador() {

        $this->db->select('ae.data,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicoconveniorm() {
        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.autorizacao,
            ae.data,
            al.situacao as situacaolaudo,
            o.nome as revisor,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where('al.medico_parecer1', $_POST['medicos']);
        if ($_POST['convenio'] != "0") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->where('pt.grupo', 'RM');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioaniversariantes() {

        $mes = $_POST['txtdata_inicio'];

        $sql = "SELECT p.nome as paciente, p.nascimento , p.celular , p.telefone from ponto.tb_paciente p
                left join ponto.tb_convenio c on c.convenio_id = p.convenio_id
                Where Extract(Month From p.nascimento) = $mes order by Extract(Day From p.nascimento)";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function relatoriomedicoconveniocontadorrm() {

        $this->db->select('ae.data,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where('al.medico_parecer1', $_POST['medicos']);
        if ($_POST['convenio'] != "0") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->where('pt.grupo', 'RM');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->count_all_results();
        return $return;
    }

    function percentualmedico($procedimentopercentual, $medicopercentual) {

        $this->db->select('valor');
        $this->db->from('tb_procedimento_percentual_medico');
        $this->db->where('procedimento_tuss_id', $procedimentopercentual);
        $this->db->where('medico', $medicopercentual);
        $this->db->where('ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function percentualmedicoconvenio($procedimentopercentual, $medicopercentual) {

        $this->db->select('mc.valor');
        $this->db->from('tb_procedimento_percentual_medico_convenio mc');
        $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
        $this->db->where('m.procedimento_tuss_id', $procedimentopercentual);
        $this->db->where('mc.medico', $medicopercentual);
        $this->db->where('mc.ativo', 'true');
        $return = $this->db->get();

//        var_dump($return->result());
//        die;
        return $return->result();
    }

    function relatoriomedicoconveniofinanceiro() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            pc.procedimento_convenio_id,
            ae.autorizacao,
            ae.data,
            e.situacao,
            op.operador_id,
            ae.valor_total,
            pc.procedimento_tuss_id,
            al.medico_parecer1,
            pt.perc_medico,
            al.situacao as situacaolaudo,
            tu.classificacao,
            o.nome as revisor,
            pt.percentual,
            op.nome as medico,
            ops.nome as medicosolicitante,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador ops', 'ops.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->where('e.cancelada', 'false');
        
        if ($_POST['situacao'] != "0") {
            $this->db->where('al.situacao', 'FINALIZADO');
        }
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['grupoconvenio'] != "0") {
            $this->db->where("c.convenio_grupo_id", $_POST['grupoconvenio']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));


        $this->db->orderby('al.medico_parecer1');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.paciente_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniofinanceirotodos() {

        $this->db->select('sum(ae.valor_total)as valor,
            sum(ae.quantidade) as quantidade,
            op.nome as medico');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->where('e.cancelada', 'false');

        if ($_POST['situacao'] != "0") {
            $this->db->where('al.situacao', 'FINALIZADO');
        }

        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['grupoconvenio'] != "0") {
            $this->db->where("c.convenio_grupo_id", $_POST['grupoconvenio']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('op.nome');
        $this->db->orderby('op.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconvenioprevisaofinanceiro() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.autorizacao,
            ae.data,            
            ae.valor_total,
            pc.procedimento_tuss_id,
            pc.procedimento_convenio_id,
            al.medico_parecer1,
            pt.perc_medico,
            al.situacao as situacaolaudo,
            tu.classificacao,
            o.nome as revisor,
            pt.percentual,
            op.nome as medico,
            ops.nome as medicosolicitante,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador ops', 'ops.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.procedimento_tuss_id is not null');
//        $this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));


        $this->db->orderby('al.medico_parecer1');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.paciente_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioresumogeral() {

        $this->db->select('op.nome as medico,
                           sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->where('e.cancelada', 'false');
        //$this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('op.nome');
        $this->db->orderby('op.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioresumogeralmedico() {

        $this->db->select('op.nome as medico,
                           ae.valor_total,
                           pt.perc_medico,
                           pt.procedimento_tuss_id,
                           al.medico_parecer1,
                           pt.percentual');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('e.cancelada', 'false');
//        $this->db->where('ppm.ativo', 'true');
        //$this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('op.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function gerarelatorioatendenteconvenio() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            ae.autorizacao,
            ae.data,
            ae.valor_total,
            pc.procedimento_tuss_id,
            op.nome as atendente,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
//        $this->db->where('al.situacao', 'FINALIZADO');

        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['txttecnico'] != "") {
            $this->db->where("op.operador_id", $_POST['txttecnico']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));


        $this->db->orderby('ae.operador_autorizacao');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.paciente_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniocontadorfinanceiro() {

        $this->db->select('ae.data,
            c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
//        $this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['convenio'] == "") {
            $this->db->where("c.dinheiro", "f");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriogrupo() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.autorizacao,
                            f.nome as forma_pagamento,
                            ae.paciente_id,
                            ae.operador_editar,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where("pt.grupo", $_POST['grupo']);




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriogrupocontador() {

        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where("pt.grupo", $_POST['grupo']);




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriocaixa() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.guia_id,
                            ae.inicio,
                            ae.fim,
                            ae.financeiro,
                            ae.faturado,
                            ae.ativo,
                            ae.verificado,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            pt.grupo,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.valor1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.forma_pagamento3,
                            ae.valor3,
                            ae.numero_sessao,
                            ae.forma_pagamento4,
                            ae.valor4,
                            ae.autorizacao,
                            ae.operador_autorizacao,
                            ae.paciente_id,
                            ae.operador_editar,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            o.nome,
                            e.exames_id,
                            op.nome as nomefaturamento,
                            f.nome as forma_pagamento,
                            f2.nome as forma_pagamento_2,
                            f3.nome as forma_pagamento_3,
                            f4.nome as forma_pagamento_4,
                            pt.descricao as procedimento,
                            pt.codigo,
                            ae.desconto,
                            ae.parcelas1,
                            ae.parcelas2,
                            ae.parcelas3,
                            ae.parcelas4');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamento', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_autorizacao', $_POST['operador']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('c.dinheiro', "t");
        $this->db->orderby('ae.operador_autorizacao');
//        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixacartao() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.guia_id,
                            ae.inicio,
                            ae.fim,
                            ae.financeiro,
                            ae.faturado,
                            ae.ativo,
                            ae.verificado,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            pt.grupo,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.valor1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.forma_pagamento3,
                            ae.valor3,
                            ae.numero_sessao,
                            ae.forma_pagamento4,
                            ae.valor4,
                            ae.autorizacao,
                            ae.operador_autorizacao,
                            ae.paciente_id,
                            ae.operador_editar,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            o.nome,
                            e.exames_id,
                            op.nome as nomefaturamento,
                            f.nome as forma_pagamento,
                            f2.nome as forma_pagamento_2,
                            f3.nome as forma_pagamento_3,
                            f4.nome as forma_pagamento_4,
                            pt.descricao as procedimento,
                            pt.codigo,
                            ae.desconto,
                            ae.parcelas1,
                            ae.parcelas2,
                            ae.parcelas3,
                            ae.parcelas4');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamento', 'left');

        $this->db->where('f.cartao', 't');
//        $this->db->orwhere('f2.cartao', 't');
//        $this->db->orwhere('f3.cartao', 't');
//        $this->db->orwhere('f4.cartao', 't');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_autorizacao', $_POST['operador']);
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('c.dinheiro', "t");
        $this->db->orderby('ae.operador_autorizacao');
//        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixafaturado() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.guia_id,
                            ae.inicio,
                            ae.fim,
                            ae.financeiro,
                            ae.faturado,
                            ae.ativo,
                            ae.verificado,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            pt.grupo,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.valor1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.forma_pagamento3,
                            ae.valor3,
                            ae.forma_pagamento4,
                            ae.valor4,
                            ae.autorizacao,
                            ae.operador_autorizacao,
                            ae.paciente_id,
                            ae.operador_editar,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            o.nome,
                            e.exames_id,
                            op.nome as nomefaturamento,
                            f.nome as forma_pagamento,
                            f2.nome as forma_pagamento_2,
                            f3.nome as forma_pagamento_3,
                            f4.nome as forma_pagamento_4,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamento', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.operador_autorizacao >', 0);




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_faturamento', $_POST['operador']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('c.dinheiro', "t");
        $this->db->orderby('ae.operador_faturamento');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function valoralterado($agenda_exames_id) {

        $this->db->select('ae.agenda_exames_id,
                            pt.codigo,
                            c.nome as convenio,
                            pt.nome as procedimento,
                            ae.editarvalor_total,
                            ae.editarforma_pagamento,
                            o.nome,
                            op.nome as usuario_antigo,
                            ae.editarquantidade,
                            f.nome as forma');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.editarprocedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.editarforma_pagamento', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_editar', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamentoantigo', 'left');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function verificado($agenda_exames_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.valor_total,
                            f.nome as forma');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function verificaobservacao($guia_id) {

        $this->db->select('ambulatorio_guia_id,
                            nota_fiscal,
                            recibo,
                            valor_guia,
                            observacoes');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where("ambulatorio_guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function guiaconvenio($guia_id) {

        $this->db->select('guiaconvenio,
            ambulatorio_guia_id');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where("ambulatorio_guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function verificaodeclaracao($guia_id) {

        $this->db->select('ambulatorio_guia_id,
                            declaracao');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where("ambulatorio_guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixacontador() {
        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_autorizacao', $_POST['operador']);
        }

        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('c.dinheiro', "t");
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriocaixacontadorcartao() {
        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_autorizacao', $_POST['operador']);
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('c.dinheiro', "t");
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriocaixacontadorfaturado() {

        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.operador_autorizacao >', 0);




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_faturamento', $_POST['operador']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('c.dinheiro', "t");
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriophmetria() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.autorizacao,
                            ae.paciente_id,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            f.nome as forma_pagamento,
                            pt.descricao as procedimento,
                            o.nome as medicosolicitante,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('pt.grupo', 'RX');
        $this->db->where('pc.convenio_id', '38');
        $this->db->orderby('o.nome');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriophmetriacontador() {

        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('pt.grupo', 'RX');
        $this->db->where('pc.convenio_id', '38');
        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriomedicoconveniormrevisor() {

        $this->db->select('o.nome as revisor,
            count(o.nome) as quantidade');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where('al.medico_parecer1', $_POST['medicos']);
        if ($_POST['convenio'] != "0") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->where('pt.grupo', 'RM');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniormrevisada() {

        $this->db->select('o.nome as revisor,
            count(o.nome) as quantidade');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('e.situacao', 'FINALIZADO');
        $this->db->where('al.medico_parecer2', $_POST['medicos']);
        if ($_POST['convenio'] != "0") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->where('pt.grupo', 'RM');




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function gravardeclaracaoguia($guia_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('declaracao', $_POST['declaracao']);
            $this->db->set('operador_declaracao', $operador_id);
            $this->db->set('data_declaracao', $horario);
            $this->db->where('ambulatorio_guia_id', $guia_id);
            $this->db->update('tb_ambulatorio_guia');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarexamesguia($guia_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            pt.procedimento_tuss_id,
                            ae.data,
                            ae.operador_autorizacao,
                            op.nome as operador,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.valor_total,
                            es.nome as agenda,
                            ae.guia_id,
                            ae.paciente_id,
                            ae.quantidade,
                            ae.data_autorizacao,
                            p.nome as paciente,
                            ae.forma_pagamento,
                            ae.forma_pagamento2,
                            ae.forma_pagamento3,
                            ae.forma_pagamento4,
                            p.sexo,
                            es.nome as sala,
                            c.nome as convenio,
                            ae.autorizacao,
                            fp.nome as formadepagamento,
                            fp2.nome as formadepagamento2,
                            fp3.nome as formadepagamento3,
                            fp4.nome as formadepagamento4,
                            o.nome as medicosolicitante,
                            ae.procedimento_tuss_id,
                            pt.grupo,
                            pc.convenio_id,
                            ae.data_realizacao as horafimexame,
                            l.data_atualizacao as horafimconsulta,
                            c.dinheiro,
                            ge.guiaconvenio,
                            ae.guiaconvenio as guiaexame,
                            p.convenionumero,
                            pt.codigo,
                            ope.nome as medicoagenda,
                            ope.conselho,
                            ope.cbo_ocupacao_id,
                            c.codigoidentificador,
                            c.registroans,
                            m.estado,
                            m.nome as municipio,
                            ge.declaracao,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_guia ge', 'ge.ambulatorio_guia_id = ae.guia_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_empresa ep', 'ep.empresa_id = ae.empresa_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = ep.municipio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador ope', 'ope.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id =ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento fp2', 'fp2.forma_pagamento_id =ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento fp3', 'fp3.forma_pagamento_id =ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento fp4', 'fp4.forma_pagamento_id =ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_autorizacao', 'left');
        $this->db->where("ae.guia_id", $guia_id);
        $this->db->where("ae.cancelada", "f");
        $this->db->orderby('ae.forma_pagamento');
        $this->db->orderby('ae.forma_pagamento2');
        $this->db->orderby('ae.forma_pagamento3');
        $this->db->orderby('ae.forma_pagamento4');
        $this->db->orderby('ae.guia_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamesorcamento($orcamento) {

        $this->db->select('oi.ambulatorio_orcamento_item_id,
                            oi.data,
                            o.nome as operador,
                            oi.valor_total,
                            oi.quantidade,
                            oi.valor,
                            p.nome as paciente,
                            p.sexo,
                            oi.orcamento_id,
                            c.nome as convenio,
                            pc.convenio_id,
                            c.dinheiro,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_ambulatorio_orcamento_item oi');
        $this->db->join('tb_paciente p', 'p.paciente_id = oi.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = oi.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = oi.operador_cadastro', 'left');
        $this->db->where("oi.orcamento_id", $orcamento);
        $this->db->orderby('oi.ambulatorio_orcamento_item_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamesguiaconvenio($guia_id, $convenioid) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.operador_autorizacao,
                            op.nome as operador,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.valor_total,
                            es.nome as agenda,
                            ae.guia_id,
                            ae.paciente_id,
                            ae.quantidade,
                            ae.data_atualizacao,
                            ae.data_autorizacao,
                            p.nome as paciente,
                            ae.forma_pagamento,
                            ae.forma_pagamento2,
                            ae.forma_pagamento3,
                            ae.forma_pagamento4,
                            p.sexo,
                            es.nome as sala,
                            c.nome as convenio,
                            ae.autorizacao,
                            fp.nome as formadepagamento,
                            fp2.nome as formadepagamento2,
                            fp3.nome as formadepagamento3,
                            fp4.nome as formadepagamento4,
                            o.nome as medicosolicitante,
                            ae.procedimento_tuss_id,
                            pt.grupo,
                            pc.convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id =ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento fp2', 'fp2.forma_pagamento_id =ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento fp3', 'fp3.forma_pagamento_id =ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento fp4', 'fp4.forma_pagamento_id =ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_autorizacao', 'left');
        $this->db->where("ae.guia_id", $guia_id);
        $this->db->where("c.convenio_id", $convenioid);
        $this->db->where("ae.cancelada", "f");
        $this->db->orderby('ae.guia_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexame($exames_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            pi.nome as indicacao,
                            es.nome as agenda,
                            ae.fim,
                            ae.valor_total,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.tipo,
                            ae.data_atualizacao,
                            ae.data_realizacao,
                            ae.paciente_id,
                            ae.data_entrega,
                            p.nome as paciente,
                            p.sexo,
                            p.paciente_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            ae.autorizacao,
                            ae.valor1,
                            ae.valor2,
                            ae.valor3,
                            ae.valor4,
                            ae.forma_pagamento,
                            ae.forma_pagamento2,
                            ae.forma_pagamento3,
                            ae.forma_pagamento4,
                            ae.desconto,
                            ae.data_autorizacao,
                            ae.agrupador_fisioterapia,
                            ae.numero_sessao,
                            ae.observacoes,
                            ae.qtde_sessao,
                            ae.texto,
                            o.nome as medicosolicitante,
                            op.nome as atendente,
                            opm.nome as medico,
                            opf.nome as atendente_fatura,
                            ex.exames_id,
                            fp.nome as formadepagamento,
                            ae.procedimento_tuss_id,
                            pt.grupo,
                            ep.logradouro,
                            ep.razao_social,
                            ep.cnpj,
                            ep.numero,
                            ep.telefone as telefoneempresa,
                            ep.celular as celularempresa,
                            ep.bairro,
                            ep.razao_social,
                            es.nome as sala,
                            ae.cid,
                            p.logradouro as logradouro_paciente,
                            p.numero as numero_paciente,
                            p.complemento as complemento_paciente,
                            p.bairro as bairro_paciente,
                            p.raca_cor,
                            cid.no_cid,
                            c.convenio_id,
                            c.nome as convenio,
                            ag.data_cadastro as data_guia,
                            p.nascimento,
                            p.celular,
                            p.telefone,
                            c.dinheiro,
                            ae.diabetes,
                            ae.hipertensao,
                            cbo.descricao as profissaos,
                            pt.perc_medico,
                            m.nome as municipio,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao', 'left');
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames ex', 'ex.agenda_exames_id =ae.agenda_exames_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id =ae.forma_pagamento', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador opm', 'opm.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador opf', 'opf.operador_id = ae.operador_faturamento', 'left');
        $this->db->join('tb_empresa ep', 'ep.empresa_id = ae.empresa_id', 'left');
        $this->db->join('tb_ambulatorio_guia ag', 'ag.ambulatorio_guia_id = ae.guia_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = ep.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = ae.cid', 'left');
        $this->db->where("ae.agenda_exames_id", $exames_id);
        $this->db->where("ae.cancelada", "f");
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguia($guia_id) {

        $this->db->select('sum(valor_total) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where("guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguiaforma($guia_id, $financeiro_grupo_id) {
        $this->db->select('sum(valor_total) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio_pagamento cp', 'cp.procedimento_convenio_id = ae.procedimento_tuss_id');
        $this->db->where("guia_id", $guia_id);
        if ($financeiro_grupo_id != null) {
            $this->db->where("cp.grupo_pagamento_id", $financeiro_grupo_id);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguianaofaturado($guia_id) {

        $this->db->select('sum(valor_total) as total');
        $this->db->from('tb_agenda_exames');
        $this->db->where("guia_id", $guia_id);
        $this->db->where("faturado", 'f');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguianaofaturadoforma($guia_id, $financeiro_grupo_id) {
        $this->db->select('sum(ae.valor_total) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio_pagamento cp', 'cp.procedimento_convenio_id = ae.procedimento_tuss_id');
        $this->db->where("ae.guia_id", $guia_id);
        $this->db->where("ae.faturado", 'f');
        if ($financeiro_grupo_id != null) {
            $this->db->where("cp.grupo_pagamento_id", $financeiro_grupo_id);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguiacaixa($guia_id) {

        $this->db->select('paciente_id,
                            agenda_exames_id');
        $this->db->from('tb_agenda_exames');
        $this->db->where("guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listar2($args = array()) {
        $this->db->select('ag.ambulatorio_guia_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames e', 'e.guia_id = ag.ambulatorio_guia_id', 'left');
        $this->db->orderby('ag.data_cadastro');
        $this->db->where("ag.paciente_id", $args['paciente']);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsalas() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome, tipo');
        $this->db->from('tb_exame_sala');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('excluido', 'f');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function formadepagamento() {
        $this->db->select('forma_pagamento_id,
                            nome');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function formadepagamentoprocedimento($procedimento_convenio_id) {
        $this->db->select('fp.forma_pagamento_id,
                            fp.nome as nome');
        $this->db->from('tb_procedimento_convenio_pagamento pp');
        $this->db->join('tb_grupo_formapagamento gf', 'gf.grupo_id = pp.grupo_pagamento_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('procedimento_convenio_id', $procedimento_convenio_id);
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

    function formadepagamentoguia($guia_id, $financeiro_grupo_id) {

        $this->db->select('distinct(fp.nome),
                           fp.forma_pagamento_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_grupo_formapagamento gf', 'gf.grupo_id = pp.grupo_pagamento_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('ae.guia_id', $guia_id);
        $this->db->where('gf.grupo_id', $financeiro_grupo_id);
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function verificamedico($crm) {
        $this->db->select();
        $this->db->from('tb_operador');
        $this->db->where('conselho', $crm);
        $this->db->where('medico', 'true');
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarmedico($crm) {
        $this->db->select('operador_id');
        $this->db->from('tb_operador');
        $this->db->where('conselho', $crm);
        $this->db->where('medico', 'true');
        $return = $this->db->get();
        return $return->row_array();
    }

    function listarmedicos($parametro = null) {
        $this->db->select('operador_id,
                            nome,
                            conselho');
        $this->db->from('tb_operador');
        $this->db->where('ativo', 't');
        $this->db->where('medico', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
            $this->db->orwhere('conselho ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarguia($paciente_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ambulatorio_guia_id');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->row_array();
    }

    function listarorcamento($paciente_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ambulatorio_orcamento_id');
        $this->db->from('tb_ambulatorio_orcamento');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->row_array();
    }

    function excluir($ambulatorio_guia_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_guia_id', $ambulatorio_guia_id);
        $this->db->update('tb_ambulatorio_guia');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarnovovalorprocedimento() {
        $procedimento = $_POST['procedimento'];

        $data_inicio = date("Y-m-d", strtotime($_POST['txtdata_inicio']));
        $data_fim = date("Y-m-d", strtotime($_POST['txtdata_fim']));

        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));

        $valor = str_replace(",", ".", $_POST['valor']);
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $sql = "UPDATE ponto.tb_agenda_exames 
SET data_atualizacao = '$horario', 
operador_atualizacao = $operador_id, 
valor = $valor, 
valor_total = quantidade * $valor 
WHERE procedimento_tuss_id = $procedimento 
AND data >= '$data_inicio' 
AND data <= '$data_fim'";
        $this->db->query($sql);
        return 0;
    }

    function consultargeralparticular($mes) {

        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and c.dinheiro = true
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralparticularfaturado($mes) {

        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and c.dinheiro = true
   and ae.faturado = true
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralparticularnaofaturado($mes) {

        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and c.dinheiro = true
   and ae.faturado = false
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralconveniofaturado($mes) {
        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and c.dinheiro = false
   and ae.faturado = true
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralconvenionaofaturado($mes) {
        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and c.dinheiro = false
   and ae.faturado = false
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralconvenio($mes) {
        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and c.dinheiro = false
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralsintetico($mes) {
        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = 2016
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'
                and (c.dinheiro = false
                or c.dinheiro = true)";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function gravar($paciente_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('tipo', 'EXAME');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_guia');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $ambulatorio_guia_id = $this->db->insert_id();


            return $ambulatorio_guia_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarverificado($agenda_exame_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('verificado', 't');
            $this->db->set('data_verificado', $horario);
            $this->db->set('operador_verificado', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');

            return $agenda_exame_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function recebidoresultado($agenda_exame_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('recebido', 't');
            $this->db->set('data_recebido', $horario);
            $this->db->set('operador_recebido', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');

            return $agenda_exame_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function cancelarrecebidoresultado($agenda_exame_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('recebido', 'f');
            $this->db->set('data_recebido', $horario);
            $this->db->set('operador_recebido', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');

            return $agenda_exame_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarentregaexame($agenda_exame_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('entregue', $_POST['txtentregue']);
            $this->db->set('entregue_telefone', $_POST['telefone']);
            $this->db->set('entregue_observacao', $_POST['observacaocancelamento']);
            $this->db->set('data_entregue', $horario);
            $this->db->set('operador_entregue', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');

            return $agenda_exame_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarobservacaoguia($guia_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('observacoes', $_POST['observacoes']);
        $this->db->set('nota_fiscal', $_POST['nota_fiscal']);
        $this->db->set('valor_guia', str_replace(",", ".", $_POST['txtvalorguia']));
        $this->db->set('recibo', $_POST['recibo']);
        $this->db->set('data_observacoes', $horario);
        $this->db->set('operador_observacoes', $operador_id);
        $this->db->where('ambulatorio_guia_id', $guia_id);
        $this->db->update('tb_ambulatorio_guia');
    }

    function gravarguiaconvenio($guia_id) {
        $this->db->set('guiaconvenio', $_POST['guiaconvenio']);
        $this->db->where('ambulatorio_guia_id', $guia_id);
        $this->db->update('tb_ambulatorio_guia');
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
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaralterardata($agenda_exames_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $dataautorizacao = $_POST['data'] . " " . $hora;
//            var_dump($dataautorizacao);
//            die;
            $sql = "UPDATE ponto.tb_agenda_exames
                    SET data_antiga = data
                    WHERE agenda_exames_id = $agenda_exames_id;";

            $this->db->query($sql);

//            $this->db->set('data_antiga', 'data');
            $this->db->set('data_aterardatafaturamento', $horario);
            $this->db->set('data_autorizacao', $dataautorizacao);
            $this->db->set('operador_aterardatafaturamento', $operador_id);
            $this->db->set('data', $_POST['data']);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentoconvenio() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('valor1', $_POST['valorafaturar']);
            $this->db->set('valor_total', $_POST['valorafaturar']);

            $this->db->set('data_faturamento', $horario);
            $this->db->set('operador_faturamento', $operador_id);
            $this->db->set('faturado', 't');
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentodetalhe() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('autorizacao', $_POST['autorizacao']);
            $this->db->set('observacoes', $_POST['txtobservacao']);
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('raca_cor', $_POST['raca_cor']);
            $this->db->where('paciente_id', $_POST['paciente_id']);
            $this->db->update('tb_paciente');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentototal() {
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

//            $desconto = $_POST['desconto'];
//            $valor1 = $_POST['valor1'];
//            $valor2 = $_POST['valor2'];
//            $valor3 = $_POST['valor3'];
//            $valor4 = $_POST['valor4'];

            $juros = $_POST['juros'];

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $guia = $_POST['guia_id'];

            $this->db->select('ae.agenda_exames_id, ae.valor_total, ae.guia_id, ae.paciente_id');
            $this->db->from('tb_agenda_exames ae');
            if ($_POST['financeiro_grupo_id'] != '') {
                $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
                $this->db->join('tb_financeiro_grupo fg', 'fg.financeiro_grupo_id = pp.grupo_pagamento_id', 'left');
                $this->db->where("financeiro_grupo_id", $_POST['financeiro_grupo_id']);
            }
            $this->db->where("guia_id", $guia);
            $this->db->where('confirmado', 'true');
            $query = $this->db->get();
            $returno = $query->result();

            $this->db->set('operador_id', $operador_id);
            $this->db->set('agenda_exames_id', $returno[0]->agenda_exames_id);
            $this->db->set('valor_total', $desconto);
            $this->db->set('guia_id', $returno[0]->guia_id);
            $this->db->set('paciente_id', $returno[0]->paciente_id);
            $this->db->insert('tb_ambulatorio_desconto');

            $forma1 = $_POST['formapamento1'];
            $forma2 = $_POST['formapamento2'];
            $forma3 = $_POST['formapamento3'];
            $forma4 = $_POST['formapamento4'];

            $id_juros = $returno[0]->agenda_exames_id;
            $valortotal_juros = $returno[0]->valor_total + $juros;
            $valortotal = 0;

            foreach ($returno as $value) {
                if ($value->valor_total >= $desconto) {
                    $valortotal = $value->valor_total - $desconto;
                    $desconto = 0;
                } else {
                    $valortotal = 0;
                    $desconto = $desconto - $value->valor_total;
                }
//            var_dump($desconto);
//            echo '-----';
//            var_dump($valortotal);
//            die;
                $i = 0;
                if ($valor1 > 0 && $valor1 >= $valortotal) {
                    $valor1 = $valor1 - $valortotal;
                    $this->db->set('forma_pagamento', $_POST['formapamento1']);
                    $this->db->set('valor1', str_replace(",", ".", $valortotal));
                    $this->db->set('parcelas1', $_POST['parcela1']);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $i = 1;
                } elseif ($i != 1 && $valor2 > 0 && $valor1 < $valortotal && $valor2 >= ($valortotal - $valor1)) {
                    $valor2 = $valor2 - ($valortotal - $valor1);
                    $restovalor2 = $valortotal - $valor1;
                    if ($valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                    }
                    if ($valor1 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor1 = 0;
                    $i = 2;
                } elseif ($i != 1 && $i != 2 && $valor3 > 0 && $valor2 < $valortotal && $valor3 >= ($valortotal - ($valor1 + $valor2))) {
                    $valor3 = $valor3 - ($valortotal - ($valor2 + $valor1));
                    $restovalor3 = $valortotal - ($valor2 + $valor1);
                    if ($valor1 > 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas3', $_POST['parcela3']);
                    }
                    if ($valor1 == 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                    }
                    if ($valor2 == 0 && $valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                    }
                    if ($valor2 == 0 && $valor1 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas1', $_POST['parcela3']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor2 = 0;
                    $valor1 = 0;
                    $i = 3;
                } elseif ($i != 1 && $i != 2 && $i != 3 && $valor2 < ($valortotal - $valor1) && $valor3 < ($valortotal - ($valor1 + $valor2)) && $valor4 >= ($valortotal - ($valor1 + $valor2 + $valor3))) {
                    $valor4 = $valor4 - ($valortotal - ($valor3 + $valor2 + $valor1));
                    $restovalor4 = $valortotal - ($valor3 + $valor2 + $valor1);
                    if ($valor1 > 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                        $this->db->set('valor3', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                        $this->db->set('valor4', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas4', $_POST['parcela4']);
                    }
                    if ($valor1 == 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', $_POST['parcela4']);
                    }
                    if ($valor2 > 0 && $valor1 > 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas1', $_POST['parcela3']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 > 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                    }
                    if ($valor2 > 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento4']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas1', $_POST['parcela4']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor2 = 0;
                    $valor1 = 0;
                    $valor3 = 0;
                    $i = 4;
                }
                if ($juros > 0) {
                    if ($_POST['formapamento1'] == 3) {
                        $formajuros = 3;
                    }
                    if ($_POST['formapamento1'] == 4) {
                        $formajuros = 4;
                    }
                    if ($_POST['formapamento1'] == 5) {
                        $formajuros = 5;
                    }
                    if ($_POST['formapamento1'] == 6) {
                        $formajuros = 6;
                    }
                    if ($_POST['formapamento2'] == 3) {
                        $formajuros = 3;
                    }
                    if ($_POST['formapamento2'] == 4) {
                        $formajuros = 4;
                    }
                    if ($_POST['formapamento2'] == 5) {
                        $formajuros = 5;
                    }
                    if ($_POST['formapamento2'] == 6) {
                        $formajuros = 6;
                    }

                    $this->db->set('forma_pagamento4', $formajuros);
                    $this->db->set('valor_total', $valortotal_juros);
                    $this->db->set('valor4', $juros);
                    $this->db->where('agenda_exames_id', $id_juros);
                    $this->db->update('tb_agenda_exames');
                }
                /* inicia o mapeamento no banco */
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentototalnaofaturado() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $guia = $_POST['guia_id'];

//            var_dump($_POST['financeiro_grupo_id']);die;
            $this->db->select('ae.agenda_exames_id, ae.valor_total, ae.guia_id, ae.paciente_id');
            $this->db->from('tb_agenda_exames ae');
            if ($_POST['financeiro_grupo_id'] != '') {
                $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
                $this->db->join('tb_financeiro_grupo fg', 'fg.financeiro_grupo_id = pp.grupo_pagamento_id', 'left');
                $this->db->where("fg.financeiro_grupo_id", $_POST['financeiro_grupo_id']);
            }
            $this->db->where("guia_id", $guia);
            $this->db->where("faturado", 'f');
            $this->db->where('confirmado', 'true');
            $query = $this->db->get();
            $returno = $query->result();

            $this->db->set('operador_id', $operador_id);
            $this->db->set('agenda_exames_id', $returno[0]->agenda_exames_id);
            $this->db->set('valor_total', $_POST['desconto']);
            $this->db->set('guia_id', $returno[0]->guia_id);
            $this->db->set('paciente_id', $returno[0]->paciente_id);
            $this->db->insert('tb_ambulatorio_desconto');

            $forma1 = $_POST['formapamento1'];
            $forma2 = $_POST['formapamento2'];
            $forma3 = $_POST['formapamento3'];
            $forma4 = $_POST['formapamento4'];
            $desconto = $_POST['desconto'];
            $valor1 = $_POST['valor1'];
            $valor2 = $_POST['valor2'];
            $valor3 = $_POST['valor3'];
            $valor4 = $_POST['valor4'];
            $juros = $_POST['juros'];
            $id_juros = $returno[0]->agenda_exames_id;
            $valortotal_juros = $returno[0]->valor_total + $juros;
            $valortotal = 0;


            foreach ($returno as $value) {

                if ($value->valor_total >= $desconto) {
                    $valortotal = $value->valor_total - $desconto;
                    $desconto = 0;
                } else {
                    $valortotal = 0;
                    $desconto = $desconto - $value->valor_total;
                }

                $i = 0;
                if ($valor1 > 0 && $valor1 >= $valortotal) {
                    $valor1 = $valor1 - $valortotal;
                    $this->db->set('forma_pagamento', $_POST['formapamento1']);
                    $this->db->set('valor1', str_replace(",", ".", $valortotal));
                    $this->db->set('parcelas1', $_POST['parcela1']);
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $i = 1;
                } elseif ($i != 1 && $valor2 > 0 && $valor1 < $valortotal && $valor2 >= ($valortotal - $valor1)) {
                    $valor2 = $valor2 - ($valortotal - $valor1);
                    $restovalor2 = $valortotal - $valor1;
                    if ($valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                    }
                    if ($valor1 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor1 = 0;
                    $i = 2;
                } elseif ($i != 1 && $i != 2 && $valor3 > 0 && $valor2 < $valortotal && $valor3 >= ($valortotal - ($valor1 + $valor2))) {
                    $valor3 = $valor3 - ($valortotal - ($valor2 + $valor1));
                    $restovalor3 = $valortotal - ($valor2 + $valor1);
                    if ($valor1 > 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas3', $_POST['parcela3']);
                    }
                    if ($valor1 == 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                    }
                    if ($valor2 == 0 && $valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                    }
                    if ($valor2 == 0 && $valor1 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas1', $_POST['parcela3']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor2 = 0;
                    $valor1 = 0;
                    $i = 3;
                } elseif ($i != 1 && $i != 2 && $i != 3 && $valor2 < ($valortotal - $valor1) && $valor3 < ($valortotal - ($valor1 + $valor2)) && $valor4 >= ($valortotal - ($valor1 + $valor2 + $valor3))) {
                    $valor4 = $valor4 - ($valortotal - ($valor3 + $valor2 + $valor1));
                    $restovalor4 = $valortotal - ($valor3 + $valor2 + $valor1);
                    if ($valor1 > 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                        $this->db->set('valor3', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas3', $_POST['parcela3']);
                        $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                        $this->db->set('valor4', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas4', $_POST['parcela4']);
                    }
                    if ($valor1 == 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', $_POST['parcela4']);
                    }
                    if ($valor2 > 0 && $valor1 > 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas1', $_POST['parcela3']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 > 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                    }
                    if ($valor2 > 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento4']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas1', $_POST['parcela4']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor2 = 0;
                    $valor1 = 0;
                    $valor3 = 0;
                    $i = 4;
                } elseif ($valor1 == 0 && $valor1 >= $valortotal) {
                    $valor1 = $valor1 - $valortotal;
                    $this->db->set('forma_pagamento', $_POST['formapamento1']);
                    $this->db->set('valor1', str_replace(",", ".", $valortotal));
                    $this->db->set('parcelas1', $_POST['parcela1']);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $i = 1;
                }
                if ($juros > 0) {
                    if ($_POST['formapamento1'] == 3) {
                        $formajuros = 3;
                    }
                    if ($_POST['formapamento1'] == 4) {
                        $formajuros = 4;
                    }
                    if ($_POST['formapamento1'] == 5) {
                        $formajuros = 5;
                    }
                    if ($_POST['formapamento1'] == 6) {
                        $formajuros = 6;
                    }
                    if ($_POST['formapamento2'] == 3) {
                        $formajuros = 3;
                    }
                    if ($_POST['formapamento2'] == 4) {
                        $formajuros = 4;
                    }
                    if ($_POST['formapamento2'] == 5) {
                        $formajuros = 5;
                    }
                    if ($_POST['formapamento2'] == 6) {
                        $formajuros = 6;
                    }

                    $this->db->set('forma_pagamento4', $formajuros);
                    $this->db->set('valor_total', $valortotal_juros);
                    $this->db->set('valor4', $juros);
                    $this->db->where('agenda_exames_id', $id_juros);
                    $this->db->update('tb_agenda_exames');
                }
                /* inicia o mapeamento no banco */
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentototalconvenio() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $guia = $_POST['guia_id'];

            $this->db->select('agenda_exames_id, valor_total');
            $this->db->from('tb_agenda_exames');
            $this->db->where("guia_id", $guia);
            $query = $this->db->get();
            $returno = $query->result();

            foreach ($returno as $value) {
                $this->db->set('forma_pagamento', $_POST['formapamento1']);
                $this->db->set('valor1', str_replace(",", ".", $value->valor_total));
                $this->db->set('data_faturamento', $horario);
                $this->db->set('operador_faturamento', $operador_id);
                $this->db->set('faturado', 't');
                $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function relatoriocaixaforma($formapagamento_id) {
//        var_dump($formapagamento_id);die;
        $this->db->select('ae.agenda_exames_id,
                            ae.valor1,
                            ae.parcelas1,
                            ae.forma_pagamento,
                            ae.valor2,
                            ae.parcelas2,
                            ae.forma_pagamento2,
                            ae.valor3,
                            ae.parcelas3,
                            ae.forma_pagamento3,
                            ae.valor4,
                            ae.parcelas4,
                            ae.forma_pagamento4');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where('ae.forma_pagamento', $formapagamento_id);
        $this->db->orwhere('ae.forma_pagamento2', $formapagamento_id);
        $this->db->orwhere('ae.forma_pagamento3', $formapagamento_id);
        $this->db->orwhere('ae.forma_pagamento4', $formapagamento_id);
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.financeiro', 'f');
        $this->db->where('ae.operador_autorizacao >', 0);
        $return = $this->db->get();
        return $return->result();
    }

    function burcarcontasrecebertemp() {
        $this->db->select('distinct(data)');
        $this->db->from('tb_financeiro_contasreceber_temp');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function burcarcontasrecebertemp2($data) {
        $this->db->select('sum(valor)                           
                           valor,
                           devedor,
                           parcela,
                           observacao,
                           data_cadastro,
                           operador_cadastro,
                           entrada_id,
                           conta,
                           classe');
        $this->db->from('tb_financeiro_contasreceber_temp');
        $this->db->where('data', $data);
        $this->db->where('ativo', 't');
        $this->db->groupby('devedor');
        $this->db->groupby('parcela');
        $this->db->groupby('observacao');
        $this->db->groupby('data_cadastro');
        $this->db->groupby('operador_cadastro');
        $this->db->groupby('entrada_id');
        $this->db->groupby('conta');
        $this->db->groupby('classe');
        $return = $this->db->get();
        return $return->result();
    }

    function fecharcaixa() {

//        try {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $data_inicio = $_POST['data1'];
        $data_cauculo = substr($_POST['data1'], 6, 4) . "-" . substr($_POST['data1'], 3, 2) . "-" . substr($_POST['data1'], 0, 2);
        $data_fim = $_POST['data2'];
        $observacao = "Periodo de" . $_POST['data1'] . "a" . $_POST['data2'];
        $data = date("Y-m-d");
        $data30 = date('Y-m-d', strtotime("+30 days", strtotime($data_cauculo)));
        $data4 = date('Y-m-d', strtotime("+4 days", strtotime($data_cauculo)));
        $data2 = date('Y-m-d', strtotime("+2 days", strtotime($data_cauculo)));


        $this->db->select('forma_pagamento_id,
                            nome, 
                            conta_id, 
                            credor_devedor,
                            tempo_receber, 
                            dia_receber,
                            parcelas');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $return = $this->db->get();
        $forma_pagamento = $return->result();

        $teste = $_POST['qtde'];
        $w = 0;
        foreach ($forma_pagamento as $value) {
            $classe = "CAIXA" . " " . $value->nome;
            $w++;
            $valor_total = (str_replace(".", "", $teste[$w]));
            $valor_total = (str_replace(",", ".", $valor_total));
            if ($valor_total != '0.00') {

                if (empty($value->nome) || empty($value->conta_id) || empty($value->credor_devedor) || empty($value->parcelas)) {
                    return 10;
                }

                if ((empty($value->tempo_receber) || $value->tempo_receber == 0) && (empty($value->dia_receber) || $value->dia_receber == 0)) {
                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('valor', $valor_total);
                    $this->db->set('classe', $classe);
                    $this->db->set('nome', $value->credor_devedor);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('observacao', $observacao);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_entradas');
                    $entradas_id = $this->db->insert_id();

                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('valor', $valor_total);
                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('entrada_id', $entradas_id);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('nome', $value->credor_devedor);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_saldo');
                } else {
                    if (isset($value->dia_receber) && $value->dia_receber > 0) {
                        $data_atual = date("Y-m-d");
                        $dia_atual = substr(date("Y-m-d"), 8);
                        $mes_atual = substr(date("Y-m-d"), 5, 2);
                        $ano_atual = substr(date("Y-m-d"), 0, 4);

                        if ($dia_atual < $value->dia_receber) {
                            $data_receber = $ano_atual . '-' . $mes_atual . '-' . $value->dia_receber;
                        } else {
                            $data_passada = $ano_atual . '-' . $mes_atual . '-' . $value->dia_receber;
                            $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_passada)));
                        }

                        $valor_n_parcelado = $valor_total;
                        $agenda_exames_id = $this->relatoriocaixaforma($value->forma_pagamento_id);

                        foreach ($agenda_exames_id as $item) {
                            if ($item->forma_pagamento == $value->forma_pagamento_id) {
                                $parcelas = $item->parcelas1;
                                $valor = $item->valor1;
//                                    $retorno = $this->parcelas1($item->agenda_exames_id);
                            } elseif ($item->forma_pagamento2 == $value->forma_pagamento_id) {
                                $parcelas = $item->parcelas2;
                                $valor = $item->valor2;
//                                    $retorno = $this->parcelas2($item->agenda_exames_id);
                            } elseif ($item->forma_pagamento3 == $value->forma_pagamento_id) {
                                $parcelas = $item->parcelas3;
                                $valor = $item->valor3;
//                                    $retorno = $this->parcelas3($item->agenda_exames_id);
                            } elseif ($item->forma_pagamento4 == $value->forma_pagamento_id) {
                                $parcelas = $item->parcelas4;
                                $valor = $item->valor4;
//                                    $retorno = $this->parcelas4($item->agenda_exames_id);
                            }
                            $mes = 1;

                            if ($parcelas > 1) {
                                $jurosporparcelas = $this->jurosporparcelas($value->forma_pagamento_id, $parcelas);

                                if ($jurosporparcelas[0]->taxa_juros > 0) {
                                    $taxa_juros = $jurosporparcelas[0]->taxa_juros;
                                } else {
                                    $taxa_juros = 0;
                                }

                                $valor_com_juros = $valor + ($valor * ($taxa_juros / 100));
                                $valor_parcelado = $valor_com_juros / $parcelas;
                            } else {
                                $valor_parcelado = $valor;
                            }

                            if ($parcelas > 1) {
                                for ($i = 2; $i <= $parcelas; $i++) {
                                    $data_receber_p = date("Y-m-d", strtotime("+$mes month", strtotime($data_receber)));

                                    $this->db->set('valor', $valor_parcelado);
                                    $this->db->set('devedor', $value->credor_devedor);
                                    $this->db->set('parcela', $i);
                                    $this->db->set('data', $data_receber_p);
                                    $this->db->set('classe', $classe);
                                    $this->db->set('conta', $value->conta_id);
                                    $this->db->set('observacao', $observacao);
                                    $this->db->set('data_cadastro', $horario);
                                    $this->db->set('operador_cadastro', $operador_id);
                                    $this->db->insert('tb_financeiro_contasreceber_temp');
                                    $mes++;
                                }
                                $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
                            }
                        }

                        $this->db->set('valor', $valor_n_parcelado);
                        $this->db->set('devedor', $value->credor_devedor);
                        $this->db->set('data', $data_receber);
                        $this->db->set('classe', $classe);
                        $this->db->set('conta', $value->conta_id);
                        $this->db->set('observacao', $observacao);
                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_financeiro_contasreceber');

                        $receber_temp = $this->burcarcontasrecebertemp();
                        foreach ($receber_temp as $temp) {
                            $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
                            $this->db->set('valor', $receber_temp2[0]->valor);
                            $this->db->set('devedor', $receber_temp2[0]->devedor);
                            $this->db->set('data', $temp->data);
                            $this->db->set('parcela', $receber_temp2[0]->parcela);
                            $this->db->set('classe', $receber_temp2[0]->classe);
                            $this->db->set('conta', $receber_temp2[0]->conta);
                            $this->db->set('observacao', $receber_temp2[0]->observacao);
                            $this->db->set('data_cadastro', $receber_temp2[0]->data_cadastro);
                            $this->db->set('operador_cadastro', $receber_temp2[0]->operador_cadastro);
                            $this->db->insert('tb_financeiro_contasreceber');
                        }
                        $this->db->set('ativo', 'f');
                        $this->db->update('tb_financeiro_contasreceber_temp');
                    } else {
                        if (isset($value->tempo_receber) && $value->tempo_receber > 0) {
                            $valor_n_parcelado = $valor_total;
                            $agenda_exames_id = $this->relatoriocaixaforma($value->forma_pagamento_id);

                            foreach ($agenda_exames_id as $item) {
                                if ($item->forma_pagamento == $value->forma_pagamento_id) {
                                    $parcelas = $item->parcelas1;
                                    $valor = $item->valor1;
//                                    $retorno = $this->parcelas1($item->agenda_exames_id);
                                } elseif ($item->forma_pagamento2 == $value->forma_pagamento_id) {
                                    $parcelas = $item->parcelas2;
                                    $valor = $item->valor2;
//                                    $retorno = $this->parcelas2($item->agenda_exames_id);
                                } elseif ($item->forma_pagamento3 == $value->forma_pagamento_id) {
                                    $parcelas = $item->parcelas3;
                                    $valor = $item->valor3;
//                                    $retorno = $this->parcelas3($item->agenda_exames_id);
                                } elseif ($item->forma_pagamento4 == $value->forma_pagamento_id) {
                                    $parcelas = $item->parcelas4;
                                    $valor = $item->valor4;
//                                    $retorno = $this->parcelas4($item->agenda_exames_id);
                                }

                                if ($parcelas > 1) {
                                    $jurosporparcelas = $this->jurosporparcelas($value->forma_pagamento_id, $parcelas);

                                    if ($jurosporparcelas[0]->taxa_juros > 0) {
                                        $taxa_juros = $jurosporparcelas[0]->taxa_juros;
                                    } else {
                                        $taxa_juros = 0;
                                    }
                                    $valor_com_juros = $valor + ($valor * ($taxa_juros / 100));
                                    $valor_parcelado = $valor_com_juros / $parcelas;
                                } else {
                                    $valor_parcelado = $valor;
                                }

                                $tempo_receber = $value->tempo_receber;
                                if ($parcelas > 1) {
                                    for ($i = 2; $i <= $parcelas; $i++) {
                                        $tempo_receber = $tempo_receber + $value->tempo_receber;
                                        $data_atual = date("Y-m-d");
                                        $data_receber_p = date("Y-m-d", strtotime("+$tempo_receber days", strtotime($data_atual)));

                                        $this->db->set('valor', $valor_parcelado);
                                        $this->db->set('devedor', $value->credor_devedor);
                                        $this->db->set('parcela', $i);
                                        $this->db->set('data', $data_receber_p);
                                        $this->db->set('classe', $classe);
                                        $this->db->set('conta', $value->conta_id);
                                        $this->db->set('observacao', $observacao);
                                        $this->db->set('data_cadastro', $horario);
                                        $this->db->set('operador_cadastro', $operador_id);
                                        $this->db->insert('tb_financeiro_contasreceber_temp');
                                    }
                                    $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
                                }
                            }
                            $data_atual = date("Y-m-d");
                            $data_receber = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_atual)));

                            $this->db->set('valor', $valor_n_parcelado);
                            $this->db->set('devedor', $value->credor_devedor);
                            $this->db->set('data', $data_receber);
                            $this->db->set('classe', $classe);
                            $this->db->set('conta', $value->conta_id);
                            $this->db->set('observacao', $observacao);
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_financeiro_contasreceber');

                            $receber_temp = $this->burcarcontasrecebertemp();
                            foreach ($receber_temp as $temp) {
                                $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
                                $this->db->set('valor', $receber_temp2[0]->valor);
                                $this->db->set('devedor', $receber_temp2[0]->devedor);
                                $this->db->set('data', $temp->data);
                                $this->db->set('parcela', $receber_temp2[0]->parcela);
                                $this->db->set('classe', $receber_temp2[0]->classe);
                                $this->db->set('conta', $receber_temp2[0]->conta);
                                $this->db->set('observacao', $receber_temp2[0]->observacao);
                                $this->db->set('data_cadastro', $receber_temp2[0]->data_cadastro);
                                $this->db->set('operador_cadastro', $receber_temp2[0]->operador_cadastro);
                                $this->db->insert('tb_financeiro_contasreceber');
                            }
                            $this->db->set('ativo', 'f');
                            $this->db->update('tb_financeiro_contasreceber_temp');
                        }
                    }
                }
            }



//            if ($_POST[$value->nome] != '0,00') {
//                if ($value->nome == 'dinheiro' || $value->nome == 'DINHEIRO') {
//                    $this->db->set('data', $_POST['data1']);
//                    $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST[$value->nome])));
//                    $this->db->set('tipo', $tipo);
//                    $this->db->set('nome', 14);
//                    $this->db->set('conta', 1);
//                    $this->db->set('observacao', $observacao);
//                    $this->db->set('data_cadastro', $horario);
//                    $this->db->set('operador_cadastro', $operador_id);
//                    $this->db->insert('tb_entradas');
//                    $entradas_id = $this->db->insert_id();
//
//                    $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST[$value->nome])));
//                    $this->db->set('entrada_id', $entradas_id);
//                    $this->db->set('conta', 1);
//                    $this->db->set('nome', 14);
//                    $this->db->set('data_cadastro', $horario);
//                    $this->db->set('operador_cadastro', $operador_id);
//                    $this->db->insert('tb_saldo');
//                } elseif ($value->nome == 'cheque' || $value->nome == 'CHEQUE') {
//
//                    $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST[$value->nome])));
//                    $this->db->set('devedor', 14);
//                    $this->db->set('data', $data4);
//                    $this->db->set('tipo', $tipo);
//                    $this->db->set('conta', 1);
//                    $this->db->set('observacao', $observacao);
//                    $this->db->set('data_cadastro', $horario);
//                    $this->db->set('operador_cadastro', $operador_id);
//                    $this->db->insert('tb_financeiro_contasreceber');
//                } elseif ($value->nome == 'DEBITO' || $value->nome == 'debito' || $value->nome == 'DÉBITO' || $value->nome == 'débito') {
//
//                    $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST[$value->nome])));
//                    $this->db->set('devedor', 14);
//                    $this->db->set('data', $data4);
//                    $this->db->set('tipo', 'CAIXA DEBITO EM CONTA');
//                    $this->db->set('conta', 1);
//                    $this->db->set('observacao', $observacao);
//                    $this->db->set('data_cadastro', $horario);
//                    $this->db->set('operador_cadastro', $operador_id);
//                    $this->db->insert('tb_financeiro_contasreceber');
//                } else {
//                    $cartao[$value->nome] = str_replace(",", ".", str_replace(".", "", $_POST[$value->nome]));
////            $cartaovisa = $cartaovisa * 0.965;
//                    $cartao[$value->nome] = $cartao[$value->nome] * 1;
//                    $this->db->set('valor', $cartao[$value->nome]);
//                    $this->db->set('devedor', 14);
//                    $this->db->set('data', $data30);
//                    $this->db->set('tipo', $tipo);
//                    $this->db->set('conta', 6);
//                    $this->db->set('observacao', $observacao);
//                    $this->db->set('data_cadastro', $horario);
//                    $this->db->set('operador_cadastro', $operador_id);
//                    $this->db->insert('tb_financeiro_contasreceber');
//                }
//            }
        }

        if ($_POST['grupo'] == 0) {

            $sql = "UPDATE ponto.tb_agenda_exames
SET operador_financeiro = $operador_id, data_financeiro= '$horario', financeiro = 't'
where agenda_exames_id in (SELECT ae.agenda_exames_id
FROM ponto.tb_agenda_exames ae 
LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id 
LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id 
LEFT JOIN ponto.tb_exames e ON e.agenda_exames_id = ae.agenda_exames_id 
LEFT JOIN ponto.tb_ambulatorio_laudo al ON al.exame_id = e.exames_id 
LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id 
WHERE e.cancelada = 'false' 
AND ae.data >= '$data_inicio' 
AND ae.data <= '$data_fim' 
AND c.dinheiro = true 
ORDER BY ae.agenda_exames_id)";
            $this->db->query($sql);
        }

        if ($_POST['grupo'] == 1) {

            $sql = "UPDATE ponto.tb_agenda_exames
SET operador_financeiro = $operador_id, data_financeiro= '$horario', financeiro = 't'
where agenda_exames_id in (SELECT ae.agenda_exames_id
FROM ponto.tb_agenda_exames ae 
LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id 
LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id 
LEFT JOIN ponto.tb_exames e ON e.agenda_exames_id = ae.agenda_exames_id 
LEFT JOIN ponto.tb_ambulatorio_laudo al ON al.exame_id = e.exames_id 
LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id 
WHERE e.cancelada = 'false' 
AND ae.data >= '$data_inicio' 
AND ae.data <= '$data_fim' 
AND pt.grupo != 'RM'
AND c.dinheiro = true  
ORDER BY ae.agenda_exames_id)";
            $this->db->query($sql);
        }

        if ($_POST['grupo'] == "RM") {

            $sql = "UPDATE ponto.tb_agenda_exames
SET operador_financeiro = $operador_id, data_financeiro= '$horario',financeiro = 't'
where agenda_exames_id in (SELECT ae.agenda_exames_id
FROM ponto.tb_agenda_exames ae 
LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id 
LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id 
LEFT JOIN ponto.tb_exames e ON e.agenda_exames_id = ae.agenda_exames_id 
LEFT JOIN ponto.tb_ambulatorio_laudo al ON al.exame_id = e.exames_id 
LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id 
WHERE e.cancelada = 'false' 
AND ae.data >= '$data_inicio' 
AND ae.data <= '$data_fim' 
AND pt.grupo = 'RM'
AND c.dinheiro = true  
ORDER BY ae.agenda_exames_id)";
            $this->db->query($sql);
        }


//
//        if ($_POST['dinheiro'] != '0,00') {
//
//            $this->db->set('data', $_POST['data1']);
//            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['dinheiro'])));
//            $this->db->set('tipo', 'CAIXA DINHEIRO');
//            $this->db->set('nome', 14);
//            $this->db->set('conta', 1);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_entradas');
//            $entradas_id = $this->db->insert_id();
//
//            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['dinheiro'])));
//            $this->db->set('entrada_id', $entradas_id);
//            $this->db->set('conta', 1);
//            $this->db->set('nome', 14);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_saldo');
//        }
//
//        if ($_POST['cheque'] != '0,00') {
//
//            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['cheque'])));
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data4);
//            $this->db->set('tipo', 'CAIXA CHEQUE');
//            $this->db->set('conta', 1);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
//
//        if ($_POST['debito'] != '0,00') {
//
//            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['debito'])));
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data4);
//            $this->db->set('tipo', 'CAIXA DEBITO EM CONTA');
//            $this->db->set('conta', 1);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
//
//        if ($_POST['cartaovisa'] != '0,00') {
//            $cartaovisa = str_replace(",", ".", str_replace(".", "", $_POST['cartaovisa']));
////            $cartaovisa = $cartaovisa * 0.965;
//            $cartaovisa = $cartaovisa * 1;
//            $this->db->set('valor', $cartaovisa);
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data30);
//            $this->db->set('tipo', 'CAIXA CARTAO VISA');
//            $this->db->set('conta', 6);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
//
//        if ($_POST['cartaocredito'] != '0,00') {
//            $cartaocredito = str_replace(",", ".", str_replace(".", "", $_POST['cartaocredito']));
////            $cartaovisa = $cartaovisa * 0.965;
//            $cartaocredito = $cartaocredito * 1;
//            $this->db->set('valor', $cartaocredito);
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data30);
//            $this->db->set('tipo', 'CAIXA CARTAO CREDITO');
//            $this->db->set('conta', 6);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
//
//        if ($_POST['cartaomaster'] != '0,00') {
//            $cartaomaster = str_replace(",", ".", str_replace(".", "", $_POST['cartaomaster']));
////            $cartaomaster = $cartaomaster * 0.965;
//            $cartaomaster = $cartaomaster * 1;
//            $this->db->set('valor', $cartaomaster);
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data30);
//            $this->db->set('tipo', 'CAIXA CARTAO MASTER');
//            $this->db->set('conta', 6);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
//
//        if ($_POST['cartaohiper'] != '0,00') {
//            $cartaohiper = str_replace(",", ".", str_replace(".", "", $_POST['cartaohiper']));
////            $cartaohiper = $cartaohiper * 0.965;
//            $cartaohiper = $cartaohiper * 1;
//            $this->db->set('valor', $cartaomaster);
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data30);
//            $this->db->set('tipo', 'CAIXA CARTAO HIPER');
//            $this->db->set('conta', 6);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
//        if ($_POST['outros'] != '0,00') {
//            $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $_POST['outros'])));
//            $this->db->set('devedor', 14);
//            $this->db->set('data', $data2);
//            $this->db->set('tipo', 'CAIXA OUTROS');
//            $this->db->set('conta', 1);
//            $this->db->set('observacao', $observacao);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_financeiro_contasreceber');
//        }
    }

    function jurosporparcelas($formapagamento_id, $parcelas) {
        $this->db->select('taxa_juros');
        $this->db->from('tb_formapagamento_pacela_juros');
        $this->db->where('forma_pagamento_id', $formapagamento_id);
        $this->db->where('parcelas_inicio <=', $parcelas);
        $this->db->where('parcelas_fim >=', $parcelas);
        $query = $this->db->get();

        return $query->result();
    }

    function fecharmedico() {
//        try {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');


        $this->db->set('data', $data);
        $this->db->set('valor', $_POST['valor']);
        $this->db->set('tipo', $_POST['tipo']);
        $this->db->set('credor', $_POST['nome']);
        if ($_POST['conta'] != '') {
            $this->db->set('conta', $_POST['conta']);
        }
        $this->db->set('observacao', $_POST['observacao']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_financeiro_contaspagar');
        $saida_id = $this->db->insert_id();
    }

    function listardados($convenio) {
        $this->db->select('nome,
                            dinheiro,
                            credor_devedor_id,
                            conta_id');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        $this->db->where("convenio_id", $convenio);
        $return = $this->db->get();
        return $return->result();
    }

    function selecionarprocedimentos($procedimentos) {
        $this->db->select('nome');
        $this->db->from('tb_procedimento_tuss');
        $this->db->where("procedimento_tuss_id", $procedimentos);
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresas() {

        $this->db->select('empresa_id,
            razao_social,
            producaomedicadinheiro,
            nome');
        $this->db->from('tb_empresa');
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarclassificacao() {

        $this->db->select('tuss_classificacao_id,
            nome');
        $this->db->from('tb_tuss_classificacao');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentos() {

        $this->db->select('procedimento_tuss_id,
            nome');
        $this->db->from('tb_procedimento_tuss');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupo() {

        $this->db->select('ambulatorio_grupo_id,
            nome');
        $this->db->from('tb_ambulatorio_grupo');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresa($empresa_id = null) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('razao_social,
                            logradouro,
                            numero,
                            nome,
                            telefone,
                            producaomedicadinheiro,
                            celular,
                            bairro,
                            impressao_tipo');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function verificasessoesabertas($procedimento_convenio_id, $paciente_id) {
        $this->db->select('pt.grupo,
                            c.nome,
                            c.dinheiro,
                            c.convenio_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_convenio_id);
        $return = $this->db->get();
        $x = $return->result();
        $especialidade = $x[0]->grupo;
        $convenio_id = $x[0]->convenio_id;

//        var_dump($return->result()); die;

        if ($x[0]->dinheiro == 'f') {
//            $this->db->select('confirmado , agenda_exames_id');
//            $this->db->from('tb_agenda_exames');
//            $this->db->where('tipo', $especialidade);
////            $this->db->where('tipo', 'FISIOTERAPIA');
//            $this->db->where('ativo', 'false');
//            $this->db->where('numero_sessao >=', '1');
//            $this->db->where('realizada', 'false');
//            $this->db->where('confirmado', 'false');
//            $this->db->where('cancelada', 'false');
//            $return = $this->db->get();
//            $result = $return->result();

            $data = date("Y-m-d");
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.realizada,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.numero_sessao,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.grupo ,
                            al.situacao as situacaolaudo');
            $this->db->from('tb_agenda_exames ae');
            $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
            $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
            $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
            $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
            $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
            $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
            $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
            $this->db->orderby('ae.data');
            $this->db->orderby('ae.numero_sessao');
            $this->db->where('ae.empresa_id', $empresa_id);
            $this->db->where('ae.paciente_id', $paciente_id);
//            $this->db->where('ae.tipo ', $especialidade);//////////////////////
            $this->db->where('pt.grupo ', $especialidade);
            $this->db->where('c.convenio_id', $convenio_id);
            $this->db->where('ae.ativo', 'false');
            $this->db->where('ae.numero_sessao >=', '1');
            $this->db->where('ae.realizada', 'false');
//            $this->db->where('ae.confirmado', 'false');
            $this->db->where('ae.cancelada', 'false');
            $return = $this->db->get();
            $result = $return->result();


//            $contador = 0;
//            foreach ($result as $item) {
//                $data_atual = date('Y-m-d');
//                $data1 = new DateTime($data_atual);
//                $data2 = new DateTime($item->data);
//                $intervalo = $data1->diff($data2);
//
//                if ($intervalo->d == 0) {
//                    $contador++;
//                }
//            }
//
//            echo '<pre>';
//            var_dump($result);die;

            if (count($result) != 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function gravarguia($paciente_id) {
//        var_dump($paciente_id);die;
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('tipo', 'EXAME');
        $this->db->set('data_criacao', $data);
        $this->db->set('convenio_id', $_POST['convenio1']);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_guia');
        $ambulatorio_guia_id = $this->db->insert_id();
        return $ambulatorio_guia_id;
    }

    function gravarorcamento($paciente_id) {
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('data_criacao', $data);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_orcamento');
        $ambulatorio_guia_id = $this->db->insert_id();
        return $ambulatorio_guia_id;
    }

    function gravarmedico($crm) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set('conselho', $crm);
        $this->db->set('nome', $_POST['medico1']);
        $this->db->set('medico', 't');
        $this->db->insert('tb_operador');
        $medico_id = $this->db->insert_id();
        return $medico_id;
    }

    function gravarexames($ambulatorio_guia_id, $medico_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            if ($_POST['medicoagenda'] != "") {
                $this->db->set('medico_agenda', $_POST['medicoagenda']);
                $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
            }
            $this->db->set('valor', $_POST['valor1']);
            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
//            $this->db->set('observacoes', $_POST['observacao']);
            if ($_POST['ordenador'] != "") {
                $this->db->set('ordenador', $_POST['ordenador']);
                ;
            }
            if ($_POST['data'] != "") {
                $this->db->set('data_entrega', $_POST['data']);
            }
            $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
            $this->db->set('inicio', $hora);
            $this->db->set('fim', $hora);
            if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                $this->db->set('faturado', 't');
                $this->db->set('valor1', $valortotal);
                $this->db->set('operador_faturamento', $operador_id);
                $this->db->set('data_faturamento', $horario);
                $this->db->set('forma_pagamento', $_POST['formapamento']);
            }
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('confirmado', 't');
            $this->db->set('tipo', 'EXAME');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $ambulatorio_guia_id);

            $this->db->set('paciente_id', $_POST['txtpaciente_id']);

            $this->db->set('medico_solicitante', $medico_id);

            $this->db->set('data', $data);
            $this->db->set('data_autorizacao', $horario);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('operador_autorizacao', $operador_id);
            $this->db->insert('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                $agenda_exames_id = $this->db->insert_id();
                $this->db->set('senha', md5($agenda_exames_id));
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }

            $this->db->select('ae.agenda_exames_id,
                            ae.paciente_id,
                            p.nome as paciente,
                            p.nascimento,
                            p.sexo,
                            ae.agenda_exames_id,
                            ae.inicio,
                            c.nome as convenio,
                            ae.operador_autorizacao,
                            o.nome as tecnico,
                            ae.data_autorizacao,
                            pt.nome as procedimento,
                            pt.codigo,
                            ae.guia_id,
                            pt.grupo,
                            pc.procedimento_tuss_id');
            $this->db->from('tb_agenda_exames ae');
            $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
            $this->db->join('tb_operador o', 'o.operador_id = ae.operador_autorizacao', 'left');
            $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
            $query = $this->db->get();
            $return = $query->result();


            $grupo = $return[0]->grupo;
            if ($grupo == 'RX' || $grupo == 'MAMOGRAFIA') {
                $grupo = 'CR';
            }
            if ($grupo == 'RM') {
                $grupo = 'MR';
            }

            if ($grupo == 'TOMOGRAFIA') {
                $grupo = 'CT';
            }
            if ($grupo == 'DENSITOMETRIA') {
                $grupo = 'DX';
            }


            $this->db->set('wkl_aetitle', "AETITLE");
            $this->db->set('wkl_procstep_startdate', str_replace("-", "", date("Y-m-d")));
            $this->db->set('wkl_procstep_starttime', str_replace(":", "", date("H:i:s")));
            $this->db->set('wkl_modality', $grupo);
            $this->db->set('wkl_perfphysname', $return[0]->tecnico);
            $this->db->set('wkl_procstep_descr', $return[0]->procedimento);
            $this->db->set('wkl_procstep_id', $return[0]->codigo);
            $this->db->set('wkl_reqprocid', $return[0]->codigo);
            $this->db->set('wkl_reqprocdescr', $return[0]->procedimento);
            $this->db->set('wkl_studyinstuid', $agenda_exames_id);
            $this->db->set('wkl_accnumber', $agenda_exames_id);
            $this->db->set('wkl_reqphysician', $return[0]->convenio);
            $this->db->set('wkl_patientid', $return[0]->paciente_id);
            $this->db->set('wkl_patientname', $return[0]->paciente);
            $this->db->set('wkl_patientbirthdate', str_replace("-", "", $return[0]->nascimento));
            $this->db->set('wkl_patientsex', $return[0]->sexo);
            $this->db->set('wkl_exame_id', $agenda_exames_id);

            $this->db->insert('tb_integracao');


            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function verificaexamemedicamento($procedimento_convenio_id) {

        $this->db->select('ag.tipo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_convenio_id);
        $query = $this->db->get();
        $tipo = $query->result();
        return $tipo[0]->tipo;
    }

    function gravaratendimemto($ambulatorio_guia_id, $medico_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $qtde = $_POST['qtde'];
            for ($index = 1; $index <= $qtde; $index++) {

                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                if ($_POST['medicoagenda'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                    $this->db->set('medico_agenda', $_POST['medicoagenda']);
                }
                $this->db->set('convenio_id', $_POST['convenio1']);
                $this->db->set('quantidade', '1');
                if ($dinheiro == "t") {
                    if ($index == 1) {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 't');
                    } else {
                        die;
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', 0);
                        $this->db->set('confirmado', 'f');
                    }
                } else {
                    if ($index == 1) {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 'f');
                    }
                }
                $this->db->set('autorizacao', $_POST['autorizacao1']);
                if ($_POST['ordenador'] != "") {
                    $this->db->set('ordenador', $_POST['ordenador']);
                    ;
                }
                if ($medico_id != "") {
                    $this->db->set('medico_solicitante', $medico_id);
                    $this->db->set('tipo', 'EXAME');
                } else {
                    $this->db->set('tipo', 'CONSULTA');
                }
                $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
                $this->db->set('inicio', $hora);
                $this->db->set('fim', $hora);
                if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                    $this->db->set('faturado', 't');
                    $this->db->set('valor1', $_POST['valor1']);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('forma_pagamento', $_POST['formapamento']);
                }
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('quantidade', '1');
                $this->db->set('ativo', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('guia_id', $ambulatorio_guia_id);
                $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                $this->db->set('numero_sessao', $index);
                $this->db->set('qtde_sessao', $qtde);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('data', $data);
                $this->db->set('data_autorizacao', $horario);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('operador_autorizacao', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                $agenda_exames_id = $this->db->insert_id();
                $this->db->set('senha', md5($agenda_exames_id));
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarorcamentoitem($ambulatorio_orcamento_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);

            $this->db->set('valor', $_POST['valor1']);
            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('orcamento_id', $ambulatorio_orcamento_id);

            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('data', $data);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_orcamento_item');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            }
            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsulta($ambulatorio_guia_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            if ($_POST['medicoagenda'] != "") {
                $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                $this->db->set('medico_agenda', $_POST['medicoagenda']);
            }
            $this->db->set('valor', $_POST['valor1']);
            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
//            $this->db->set('observacoes', $_POST['observacao']);
            if ($_POST['ordenador'] != "") {
                $this->db->set('ordenador', $_POST['ordenador']);
                ;
            }
            $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
            $this->db->set('inicio', $hora);
            $this->db->set('fim', $hora);
            if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                $this->db->set('faturado', 't');
                $this->db->set('valor1', $valortotal);
                $this->db->set('operador_faturamento', $operador_id);
                $this->db->set('data_faturamento', $horario);
                $this->db->set('forma_pagamento', $_POST['formapamento']);
            }
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('confirmado', 't');
            $this->db->set('tipo', 'CONSULTA');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $ambulatorio_guia_id);

            $this->db->set('paciente_id', $_POST['txtpaciente_id']);

            $this->db->set('data', $data);
            $this->db->set('data_autorizacao', $horario);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('operador_autorizacao', $operador_id);
            $this->db->insert('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                $agenda_exames_id = $this->db->insert_id();
                $this->db->set('senha', md5($agenda_exames_id));
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }

            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfisioterapia($ambulatorio_guia_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $qtde = $_POST['qtde'];
            for ($index = 1; $index <= $qtde; $index++) {

                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                if ($_POST['medicoagenda'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                    $this->db->set('medico_agenda', $_POST['medicoagenda']);
                }
                $this->db->set('convenio_id', $_POST['convenio1']);
                $this->db->set('quantidade', '1');
                if ($dinheiro == "t") {
                    if ($index == 1) {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', 0);
                        $this->db->set('confirmado', 'f');
                    }
                } else {
                    if ($index == 1) {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 'f');
                    }
                }
                $this->db->set('autorizacao', $_POST['autorizacao1']);
                if ($_POST['ordenador'] != "") {
                    $this->db->set('ordenador', $_POST['ordenador']);
                    ;
                }
                $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
                $this->db->set('inicio', $hora);
                $this->db->set('fim', $hora);
                if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                    $this->db->set('faturado', 't');
                    if ($index == 1) {
                        $this->db->set('valor1', $_POST['valor1']);
                    } else {
                        $this->db->set('valor1', 0);
                    }
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('forma_pagamento', $_POST['formapamento']);
                }
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('quantidade', '1');
                $this->db->set('tipo', 'ESPECIALIDADE');
                $this->db->set('ativo', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('guia_id', $ambulatorio_guia_id);
                $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                $this->db->set('numero_sessao', $index);
                $this->db->set('qtde_sessao', $qtde);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('data', $data);
                $this->db->set('data_autorizacao', $horario);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('operador_autorizacao', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                $agenda_exames_id = $this->db->insert_id();
                $this->db->set('senha', md5($agenda_exames_id));
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpsicologia($ambulatorio_guia_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $qtde = $_POST['qtde'];
            for ($index = 1; $index <= $qtde; $index++) {

                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                if ($_POST['medicoagenda'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                    $this->db->set('medico_agenda', $_POST['medicoagenda']);
                }
                $this->db->set('convenio_id', $_POST['convenio1']);
                $this->db->set('quantidade', '1');
                if ($dinheiro == "t") {
                    if ($index == 1) {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', 0);
                        $this->db->set('confirmado', 'f');
                    }
                } else {
                    if ($index == 1) {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $_POST['valor1']);
                        $this->db->set('confirmado', 'f');
                    }
                }
                $this->db->set('autorizacao', $_POST['autorizacao1']);
                if ($_POST['ordenador'] != "") {
                    $this->db->set('ordenador', $_POST['ordenador']);
                    ;
                }
                $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
                $this->db->set('inicio', $hora);
                $this->db->set('fim', $hora);
                if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                    $this->db->set('faturado', 't');
                    $this->db->set('valor1', $valortotal);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('forma_pagamento', $_POST['formapamento']);
                }
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('quantidade', '1');
                $this->db->set('tipo', 'PSICOLOGIA');
                $this->db->set('ativo', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('guia_id', $ambulatorio_guia_id);
                $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                $this->db->set('numero_sessao', $index);
                $this->db->set('qtde_sessao', $qtde);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('data', $data);
                $this->db->set('data_autorizacao', $horario);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('operador_autorizacao', $operador_id);
                $this->db->insert('tb_agenda_exames');
            }
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                $agenda_exames_id = $this->db->insert_id();
                $this->db->set('senha', md5($agenda_exames_id));
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarexamesfaturamento() {
        try {

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            $this->db->set('valor', $_POST['valor1']);
            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor1', $valortotal);
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
            $this->db->set('empresa_id', $_POST['txtempresa']);
            $this->db->set('confirmado', 't');
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('ativo', 'f');
            $this->db->set('realizada', 't');
            if ($_POST['medicoagenda'] != "") {
                $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                $this->db->set('medico_solicitante', $_POST['medicoagenda']);
            }
            $this->db->set('faturado', 't');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $_POST['txtguia_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('data', $_POST['txtdata']);
            $this->db->set('data_autorizacao', $horario);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('data_realizacao', $horario);
            $this->db->set('operador_realizacao', $operador_id);
            $this->db->set('data_faturamento', $horario);
            $this->db->set('operador_faturamento', $operador_id);
            $this->db->set('operador_autorizacao', $operador_id);
            $this->db->insert('tb_agenda_exames');
            $agenda_exames_id = $this->db->insert_id();

            $this->db->set('empresa_id', $_POST['txtempresa']);
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            $this->db->set('medico_realizador', $_POST['medicoagenda']);
            $this->db->set('situacao', 'FINALIZADO');
            $this->db->set('guia_id', $_POST['txtguia_id']);
            $this->db->set('agenda_exames_id', $agenda_exames_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_exames');
            $exames_id = $this->db->insert_id();

            if ($_POST['laudo'] == "on") {
                $this->db->set('empresa_id', $_POST['txtempresa']);
                $this->db->set('data', $_POST['txtdata']);
                $this->db->set('medico_parecer1', $_POST['medicoagenda']);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->set('exame_id', $exames_id);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['tipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);

                $this->db->insert('tb_ambulatorio_laudo');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function editarexames() {
        try {

            $this->db->set('autorizacao', $_POST['autorizacao1']);
            $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
            $this->db->set('guia_id', $_POST['guia_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('medico_solicitante', $_POST['medico']);
            $this->db->set('data_editar', $horario);
            $this->db->set('operador_editar', $operador_id);
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');

            $this->db->set('sala_id', $_POST['sala1']);
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            }

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function editarexamesselect($ambulatorio_guia_id) {

        $this->db->select('ae.autorizacao,
                              ae.medico_solicitante,
                              ae.agenda_exames_nome_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where("ae.agenda_exames_id", $ambulatorio_guia_id);
        $query = $this->db->get();
        return $query->result();
    }

    function valorexames() {
        try {
            $exame_id = "";

            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;

            $agenda_exames_id = $_POST['agenda_exames_id'];
            $this->db->select('exames_id');
            $this->db->from('tb_exames');
            $this->db->where("agenda_exames_id", $agenda_exames_id);
            $retorno = $this->db->count_all_results();

            if ($retorno > 0) {
                $agenda_exames_id = $_POST['agenda_exames_id'];
                $this->db->select('exames_id');
                $this->db->from('tb_exames');
                $this->db->where("agenda_exames_id", $agenda_exames_id);
                $query = $this->db->get();
                $return = $query->result();
                $exame_id = $return[0]->exames_id;
            }

            $dadosantigos = $this->listarvalor($agenda_exames_id);
            $this->db->set('editarforma_pagamento', $dadosantigos[0]->forma_pagamento);
            $this->db->set('editarquantidade', $dadosantigos[0]->quantidade);
            $this->db->set('editarprocedimento_tuss_id', $dadosantigos[0]->procedimento_tuss_id);
            $this->db->set('editarvalor_total', $dadosantigos[0]->valor_total);
            $this->db->set('operador_faturamentoantigo', $dadosantigos[0]->operador_faturamento);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            $this->db->set('valor', $_POST['valor1']);
            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
            $this->db->set('guia_id', $_POST['guia_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                $this->db->set('faturado', 't');
                $this->db->set('forma_pagamento', $_POST['formapamento']);
                $this->db->set('valor1', $valortotal);
                $this->db->set('forma_pagamento2', NULL);
                $this->db->set('valor2', 0);
                $this->db->set('forma_pagamento3', NULL);
                $this->db->set('valor3', 0);
                $this->db->set('forma_pagamento4', NULL);
                $this->db->set('valor4', 0);
                $this->db->set('operador_faturamento', $operador_id);
                $this->db->set('data_faturamento', $horario);
            } elseif ($_POST['formapamento'] == 0 && $dinheiro == "t") {
                $this->db->set('faturado', 'f');
                $this->db->set('forma_pagamento', NULL);
                $this->db->set('valor1', 0);
                $this->db->set('forma_pagamento2', NULL);
                $this->db->set('valor2', 0);
                $this->db->set('forma_pagamento3', NULL);
                $this->db->set('valor3', 0);
                $this->db->set('forma_pagamento4', NULL);
                $this->db->set('valor4', 0);
            }
            $this->db->set('data_editar', $horario);
            $this->db->set('operador_editar', $operador_id);
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            }

            if ($exame_id != "") {
                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->where('exames_id', $exame_id);
                $this->db->update('tb_exames');

                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->where('exame_id', $exame_id);
                $this->db->update('tb_ambulatorio_laudo');
            }



            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarvalor($agenda_exames_id) {
        $this->db->select('forma_pagamento,
                            quantidade,
                            operador_faturamento,
                            procedimento_tuss_id,
                            valor_total');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravareditarfichaxml($exames_id) {

        try {
            $p1 = $_POST['p1'];
            $p2 = $_POST['p2'];
            $p3 = $_POST['p3'];
            $p4 = $_POST['p4'];
            $p5 = $_POST['p5'];
            $p6 = $_POST['p6'];
            $p7 = $_POST['p7'];
            $p8 = $_POST['p8'];
            $p9 = $_POST['p9'];
            $p10 = $_POST['p10'];
            $p11 = $_POST['p11'];
            $p12 = $_POST['p12'];
            $p13 = $_POST['p13'];
            $p14 = $_POST['p14'];
            $p15 = $_POST['p15'];
            $p16 = $_POST['p16'];
            $p17 = $_POST['p17'];
            $p18 = $_POST['p18'];
            $p19 = $_POST['p19'];
            $p20 = $_POST['p20'];
            $peso = $_POST['txtpeso'];
            $txtp9 = $_POST['txtp9'];
            $txtp19 = $_POST['txtp19'];
            $txtp20 = $_POST['txtp20'];
            $obs = $_POST['obs'];

            $sql = "UPDATE ponto.tb_respostas_xml
                    set  peso = $peso , txtp9 = '$txtp9' , txtp19 = '$txtp19' , txtp20 = '$txtp20' , obs = '$obs',
                    perguntas_respostas = xmlelement (name perguntas ,xmlconcat (
                     xmlelement ( name  p1 , '$p1') , 
                     xmlelement ( name  p2 , '$p2') , 
                     xmlelement ( name  p3 , '$p3') , 
                     xmlelement ( name  p4 , '$p4') , 
                     xmlelement ( name  p5 , '$p5') ,
                     xmlelement ( name  p6 , '$p6') ,
                     xmlelement ( name  p7 , '$p7') ,
                     xmlelement ( name  p8 , '$p8') ,
                     xmlelement ( name  p9 , '$p9') ,
                     xmlelement ( name  p10 , '$p10') ,
                     xmlelement ( name  p11 , '$p11') ,
                     xmlelement ( name  p12 , '$p12') ,
                     xmlelement ( name  p13 , '$p13') ,
                     xmlelement ( name  p14 , '$p14') ,
                     xmlelement ( name  p15 , '$p15') ,
                     xmlelement ( name  p16 , '$p16') ,
                     xmlelement ( name  p17 , '$p17') ,
                     xmlelement ( name  p18 , '$p18') ,
                     xmlelement ( name  p19 , '$p19')  ,
                     xmlelement ( name  p20 , '$p20')
                     ))
                     WHERE agenda_exames_id = $exames_id;";


            $this->db->query($sql);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    function listarfichatexto($exames_id) {
        $this->db->select('agenda_exames_id, peso , txtp9 , txtp19 , txtp20, obs');
        $this->db->from('tb_respostas_xml');
        $this->db->where('agenda_exames_id', $exames_id);
        $return = $this->db->get();

        return $return->result();
    }

    function listarfichaxml($exames_id) {
        $this->load->dbutil();
        $query = $this->db->query("SELECT perguntas_respostas FROM ponto.tb_respostas_xml where agenda_exames_id = $exames_id");
        $config = array(
            'root' => 'root',
            'element' => 'element',
            'newline' => "\n",
            'tab' => "\t"
        );
        $return = $this->dbutil->xml_from_result($query, $config);
        return $return;
    }

    function gravarfichaxml($exames_id) {

        try {

            $teste = $this->listarfichatexto($exames_id);

            if (!isset($teste[0]->agenda_exames_id)) {

                $p1 = $_POST['p1'];
                $p2 = $_POST['p2'];
                $p3 = $_POST['p3'];
                $p4 = $_POST['p4'];
                $p5 = $_POST['p5'];
                $p6 = $_POST['p6'];
                $p7 = $_POST['p7'];
                $p8 = $_POST['p8'];
                $p9 = $_POST['p9'];
                $p10 = $_POST['p10'];
                $p11 = $_POST['p11'];
                $p12 = $_POST['p12'];
                $p13 = $_POST['p13'];
                $p14 = $_POST['p14'];
                $p15 = $_POST['p15'];
                $p16 = $_POST['p16'];
                $p17 = $_POST['p17'];
                $p18 = $_POST['p18'];
                $p19 = $_POST['p19'];
                $p20 = $_POST['p20'];
                $peso = $_POST['txtpeso'];
                $txtp9 = $_POST['txtp9'];
                $txtp19 = $_POST['txtp19'];
                $txtp20 = $_POST['txtp20'];
                $obs = $_POST['obs'];

                $sql = "INSERT INTO ponto.tb_respostas_xml(agenda_exames_id, peso , txtp9 , txtp19 , txtp20 , obs,
                    perguntas_respostas )
                    VALUES ($exames_id, $peso , '$txtp9' ,'$txtp19','$txtp20'  , '$obs' , xmlelement (name perguntas ,xmlconcat (
                     xmlelement ( name  p1 , '$p1') , 
                     xmlelement ( name  p2 , '$p2') , 
                     xmlelement ( name  p3 , '$p3') , 
                     xmlelement ( name  p4 , '$p4') , 
                     xmlelement ( name  p5 , '$p5') ,
                     xmlelement ( name  p6 , '$p6') ,
                     xmlelement ( name  p7 , '$p7') ,
                     xmlelement ( name  p8 , '$p8') ,
                     xmlelement ( name  p9 , '$p9') ,
                     xmlelement ( name  p10 , '$p10') ,
                     xmlelement ( name  p11 , '$p11') ,
                     xmlelement ( name  p12 , '$p12') ,
                     xmlelement ( name  p13 , '$p13') ,
                     xmlelement ( name  p14 , '$p14') ,
                     xmlelement ( name  p15 , '$p15') ,
                     xmlelement ( name  p16 , '$p16') ,
                     xmlelement ( name  p17 , '$p17') ,
                     xmlelement ( name  p18 , '$p18'),
                     xmlelement ( name  p19 , '$p19')  ,
                     xmlelement ( name  p20 , '$p20')
                     )));";

                $this->db->query($sql);
                return true;
            } else {
                return true;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    private function instanciar($exame_sala_id) {

        if ($exame_sala_id != 0) {
            $this->db->select('exame_sala_id, nome');
            $this->db->from('tb_ambulatorio_guia');
            $this->db->where("exame_sala_id", $exame_sala_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_exame_sala_id = $exame_sala_id;
            $this->_nome = $return[0]->nome;
        } else {
            $this->_exame_sala_id = null;
        }
    }

}

?>
