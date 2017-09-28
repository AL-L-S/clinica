<?php

class exame_model extends Model {

    var $_agenda_exames_id = null;
    var $_horarioagenda_id = null;
    var $_paciente_id = null;
    var $_procedimento_tuss_id = null;
    var $_inicio = null;
    var $_fim = null;
    var $_confirmado = null;
    var $_ativo = null;
    var $_nome = null;
    var $_data_inicio = null;
    var $_data_fim = null;

    function exame_model($agenda_exames_id = null) {
        parent::Model();
        if (isset($agenda_exames_id)) {
            $this->instanciar($agenda_exames_id);
        }
    }

    function listar($args = array()) {
        $this->db->select('agenda_exames_nome_id,
                            nome');
        $this->db->from('tb_agenda_exames_nome');
        $this->db->where('ativo', 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nome ilike', $args['nome'] . "%");
        }
        return $this->db;
    }

    function listaragendacriada($horario_id) {
        $this->db->select('distinct(horarioagenda_id),
                            medico_agenda as medico_id,
                            o.nome as medico,
                            ae.nome');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda');
        $this->db->where('horarioagenda_id', $horario_id);
        $this->db->where('paciente_id IS NULL');
        $this->db->groupby('horarioagenda_id, ae.nome, medico_agenda, o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletepaciente($parametro = null) {
        $this->db->select('paciente_id,
                            nome,
                            telefone,
                            celular,
                            nome_mae,
                            nascimento,
                            cpf,
                            logradouro,
                            numero');
        $this->db->from('tb_paciente');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function excluiragenda($agenda_id) {

        $this->db->set('ativo', 'f');
        $this->db->where('agenda_exames_nome_id', $agenda_id);
        $this->db->update('tb_agenda_exames_nome');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravarlote($b) {
        $this->db->set('lote', $b);
        $this->db->update('tb_lote');
        $erro = $this->db->_error_message();
    }

    function listarlote() {

        $this->db->select('lote');
        $this->db->from('tb_lote');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarpacientedetalhes() {
        try {
            /* inicia o mapeamento no banco */
            if ($_POST['peso'] != "") {
                $this->db->set('peso', str_replace(",", ".", $_POST['peso']));
            }
            if ($_POST['altura'] != "") {
                $this->db->set('altura', $_POST['altura']);
            }
            if ($_POST['pasistolica'] != "") {
                $this->db->set('pasistolica', $_POST['pasistolica']);
            }
            if ($_POST['padiastolica'] != "") {
                $this->db->set('padiastolica', $_POST['padiastolica']);
            }
            $this->db->where('ambulatorio_guia_id', $_POST['guia_id']);
            $this->db->update('tb_ambulatorio_guia');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarautocompletepacientenascimento($parametro = null) {
        $this->db->select('paciente_id,
                            nome,
                            telefone,
                            nascimento,
                            cpf');
        $this->db->from('tb_paciente');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $parametro))));
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarobservacoes($agenda_exame_id) {
        $this->db->select('observacoes');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exame_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarobservacoesfaturar($agenda_exame_id) {
        $this->db->select('observacao_faturamento');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exame_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarobservacoesfaturaramentomanual($agenda_exame_id) {
        $this->db->select('observacoes');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where('ambulatorio_guia_id', $agenda_exame_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarexterno($externo_id) {
        $this->db->select('nome_clinica, empresas_acesso_externo_id, ip_externo');
        $this->db->from('tb_empresas_acesso_servidores');
        $this->db->where('empresas_acesso_externo_id', $externo_id);
        $return = $this->db->get();
        return $return->result();
//        return $ip;
    }

    function listarnomeclinicaexterno($ip = null) {
        $this->db->select('nome_clinica, empresas_acesso_externo_id, ip_externo');
        $this->db->from('tb_empresas_acesso_servidores');
        if ($ip != null) {
            $this->db->where('ip_externo', $ip);
        }
        $return = $this->db->get();
        return $return->result();
//        return $ip;
    }

    function listarmedico() {
        $this->db->select('operador_id,
            nome');
        $this->db->from('tb_operador');
        $this->db->where('consulta', 'true');
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarespecialidade() {
        $this->db->select('distinct(co.cbo_ocupacao_id),
                               co.descricao');
        $this->db->from('tb_operador o');
        $this->db->join('tb_cbo_ocupacao co', 'co.cbo_ocupacao_id = o.cbo_ocupacao_id');
        $this->db->where('consulta', 'true');
        $this->db->where('o.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresas() {
        $this->db->select('empresa_id,
                               nome');
        $this->db->from('tb_empresa');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsalas() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome');
        $this->db->from('tb_exame_sala');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsalasativas() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome');
        $this->db->from('tb_exame_sala');
        $this->db->where('empresa_id', $empresa_id);
//        $this->db->where('ativo', 'true');
        $this->db->where('excluido', 'f');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsalastotal() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome');
        $this->db->from('tb_exame_sala');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupo($agenda_exames_id) {
        $this->db->select('pt.grupo');
        $this->db->from('tb_agenda_exames e');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->where('e.agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarmedicoagenda($agenda_exames_id) {
        $this->db->select('medico_agenda');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function mostrarlaudogastodesala($exame_id) {
        $this->db->select('al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.procedimento_tuss_id,
                            e.sala_id,           
                            c.nome as convenio,           
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_exames e');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->where('e.exames_id', $exame_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaritensgastos($guia_id) {
        $this->db->select('ags.ambulatorio_gasto_sala_id, 
                           ep.descricao, ags.quantidade, 
                           eu.descricao as unidade, 
                           pt.descricao as procedimento,
                           ags.descricao as descricao_gasto');
        $this->db->from('tb_ambulatorio_gasto_sala ags');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = ags.produto_id', 'left');
        $this->db->join('tb_estoque_unidade eu', 'eu.estoque_unidade_id = ep.unidade_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = ep.procedimento_id', 'left');
        $this->db->where('ags.ativo', 't');
        $this->db->where('ags.guia_id', $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarpacientegastos($exames_id) {
        $this->db->select('p.nome, p.paciente_id, p.sexo, p.nascimento, p.celular, p.convenio_id');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id', 'left');
        $this->db->where('exames_id', $exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentosadcionados($guia_id) {
        $this->db->select('ae.agenda_exames_id,
                           ae.horario_especial,
                           ae.data_autorizacao,
                           ae.data_realizacao,
                           ae.valor_total,
                           pt.nome');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.guia_id', $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentocirurgicoconvenio($convenio_id) {
        $this->db->select('pc.procedimento_convenio_id,
                           pc.valortotal,
                           pt.codigo,
                           pt.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pc.convenio_id', $convenio_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarequipescirurgicas() {
        $this->db->select('equipe_cirurgia_id, 
                           nome');
        $this->db->from('tb_equipe_cirurgia ec');
        $this->db->where('ec.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarquipeoperadores($equipe_id) {
        $this->db->select('operador_responsavel, 
                           valor as percentual,
                           funcao');
        $this->db->from('tb_equipe_cirurgia_operadores eco');
        $this->db->where('eco.ativo', 't');
        $this->db->where('eco.equipe_cirurgia_id', $equipe_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarhospitais() {
        $this->db->select('hospital_id, 
                               f.nome');
        $this->db->from('tb_hospital f');
        $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
        $this->db->where('f.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprodutossalagastos($convenio_id, $armazem_id) {


//        $this->db->select('ep.estoque_entrada_id,
//                            p.estoque_produto_id as produto_id,
//                            p.descricao,
//                            ep.validade,
//                            p.procedimento_id, 
//                            ea.descricao as armazem,
//                            eu.descricao as unidade,
//                            sum(ep.quantidade) as total');
//        $this->db->from('tb_estoque_saldo ep');
//        $this->db->join('tb_estoque_produto p', 'p.estoque_produto_id = ep.produto_id');
//        $this->db->join('tb_estoque_unidade eu', 'eu.estoque_unidade_id = p.unidade_id');
//        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = p.procedimento_id', 'left');
//        $this->db->join('tb_procedimento_convenio_produto_valor pv', 'pv.procedimento_tuss_id = p.procedimento_id', 'left');
////        $this->db->join('tb_estoque_solicitacao_itens esi', 'esi.produto_id = ep.produto_id');
//        $this->db->join('tb_estoque_armazem ea', 'ea.estoque_armazem_id = ep.armazem_id');
//        $this->db->where('ep.ativo', 'true');
//        $this->db->where('pv.ativo', 'true');
//        $this->db->where('pv.convenio_id', $convenio_id);
//        $this->db->where('ep.armazem_id', $armazem_id);
//        $this->db->groupby('ep.estoque_entrada_id, p.descricao, ep.validade, ea.descricao,p.procedimento_id,eu.descricao, p.estoque_produto_id');
//        $this->db->orderby('ep.validade');


        $this->db->select('distinct(p.estoque_produto_id) as produto_id, 
                            p.descricao, 
                            p.procedimento_id, 
                            eu.descricao as unidade
                                ');
        $this->db->from('tb_estoque_produto p');
        $this->db->join('tb_estoque_unidade eu', 'eu.estoque_unidade_id = p.unidade_id');
        $this->db->join('tb_estoque_saldo ep', 'p.estoque_produto_id = ep.produto_id');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = p.procedimento_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = p.procedimento_id', 'left');
        $this->db->where('ep.armazem_id', $armazem_id);
        $this->db->where('pc.convenio_id', $convenio_id);
        $this->db->where('pc.ativo', 'true');
        $this->db->orderby('p.descricao');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsalaagenda($agenda_exames_id) {
        $this->db->select('ae.agenda_exames_nome_id, ag.tipo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listartodassalasexames() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome');
        $this->db->from('tb_exame_sala');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('excluido', 'f');
        $this->db->where('tipo', 'EXAME');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listartodassalasgrupos() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome');
        $this->db->from('tb_exame_sala es');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('excluido', 'f');
        $this->db->where("( SELECT COUNT(*) FROM ponto.tb_exame_sala_grupo esg 
                            WHERE es.exame_sala_id = esg.exame_sala_id) > 0");
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listartodassalas() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome');
        $this->db->from('tb_exame_sala es');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('excluido', 'f');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listartodassalascalendario() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('exame_sala_id,
                            nome');
        $this->db->from('tb_exame_sala');
//        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('excluido', 'f');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarcaixaempresa() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('caixa');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarcnpj() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('cnpjxml, razao_socialxml, cnpj, registroans, cpfxml, cnes, m.codigo_ibge');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_municipio m', 'm.municipio_id = e.municipio_id', 'left');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarexames($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('e.exames_id,
                            e.agenda_exames_id,
                            e.paciente_id,
                            p.nome as paciente,
                            e.agenda_exames_id,
                            e.sala_id,
                            ae.inicio,
                            e.guia_id,
                            e.procedimento_tuss_id,
                            e.data_cadastro,
                            es.nome as sala,
                            o.nome as tecnico,
                            pt.grupo,
                            pt.nome as procedimento,
                            ag.ambulatorio_laudo_id');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id', 'left');
        $this->db->join('tb_ambulatorio_laudo ag', 'e.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = e.sala_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->where('e.situacao', 'EXECUTANDO');
        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.sala_preparo', 'f');
        $this->db->where('e.cancelada', 'false');
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('e.sala_id', $args['sala']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function gerarelatoriotempoesperaexame() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('e.exames_id,
                            e.agenda_exames_id,
                            e.paciente_id,
                            p.nome as paciente,
                            e.agenda_exames_id,
                            e.sala_id,
                            ae.inicio,
                            e.guia_id,
                            e.procedimento_tuss_id,
                            e.data_cadastro,
                            e.data_atualizacao,
                            e.operador_atualizacao,
                            es.nome as sala,
                            o.nome as tecnico,
                            pt.grupo,
                            pt.nome as procedimento');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = e.sala_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('e.cancelada', 'false');
        if ($_POST['txtdata_inicio'] != '' && $_POST['txtdata_fim'] != '') {
            $this->db->where("e.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
            $this->db->where("e.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        }
        if ($_POST['convenio'] != '') {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function gerarelatoriotemposalaespera() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ordenador,
                            ae.data_autorizacao,
                            ae.data_realizacao,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.faturado,
                            o.nome as tecnico,
                            c.dinheiro,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->orderby('ae.ordenador');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.data_autorizacao');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        if ($_POST['txtdata_inicio'] != '' && $_POST['txtdata_fim'] != '') {
            $this->db->where("ae.data_autorizacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
            $this->db->where("ae.data_autorizacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        }
        if ($_POST['convenio'] != '') {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamespendentes($args = array()) {
        $this->db->select('e.exames_id,
                            e.paciente_id,
                            p.nome as paciente,
                            e.agenda_exames_id,
                            e.sala_id,
                            ae.inicio,
                            e.data_cadastro,
                            e.data_pendente,
                            es.nome as sala,
                            pt.nome as procedimento');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = e.sala_id', 'left');
        $this->db->where('e.situacao', 'PENDENTE');
        $this->db->where('e.cancelada', 'false');
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('e.sala_id', $args['sala']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listararquivo($agenda_exames_id) {
        $this->db->select(' ae.paciente_id,
                            p.nome as paciente,
                            p.nascimento,
                            p.sexo,
                            ae.agenda_exames_id,
                            ae.inicio,
                            pt.nome as procedimento,
                            pc.procedimento_tuss_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listardicom($laudo_id) {
        $this->db->select('e.exames_id,
                            e.paciente_id,
                            p.nome as paciente,
                            p.nascimento,
                            p.sexo,
                            e.agenda_exames_id,
                            e.sala_id,
                            ae.inicio,
                            c.nome as convenio,
                            e.tecnico_realizador,
                            o.nome as tecnico,
                            e.data_cadastro,
                            pt.nome as procedimento,
                            pt.codigo,
                            ae.guia_id,
                            pt.grupo,
                            pc.procedimento_tuss_id');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->where('l.ambulatorio_laudo_id', $laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function contador($parametro, $agenda_exames_nome_id) {
        $this->db->select();
        $this->db->from('tb_agenda_exames');
        $this->db->where('data', $parametro);
        $this->db->where('nome_id', $agenda_exames_nome_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarexameagenda($parametro, $agenda_exames_nome_id) {
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.paciente_id,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = ae.procedimento_tuss_id', 'left');
        $this->db->orderby('inicio');
        $this->db->where('ae.data', $parametro);
        $this->db->where('ae.nome_id', $agenda_exames_nome_id);
        $return = $this->db->get();

        return $return->result();
    }

    function listarexamesalapreparo($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ordenador,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            es.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id', 'left');
        $this->db->join('tb_ambulatorio_laudo ag', 'e.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = e.sala_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->where('e.situacao', 'EXECUTANDO');
        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.sala_preparo', 't');
        $this->db->where('e.cancelada', 'false');
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('e.sala_id', $args['sala']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarexameagendaconfirmada($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ordenador,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.sala_preparo', 'false');
        $this->db->where('ae.tipo !=', 'CIRURGICO');
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['tipo']) && strlen($args['tipo']) > 0) {
            $this->db->where('ae.tipo', $args['tipo']);
        }
        return $this->db;
    }

    function listarexameagendaconfirmada2($args = array(), $ordem_chegada) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ordenador,
                            ae.data_autorizacao,
                            ae.ativo,
                            ae.numero_sessao,
                            ae.qtde_sessao,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            an.nome as sala,
                            ae.faturado,
                            c.dinheiro,
                            p.nome as paciente,
                            p.nascimento,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->orderby('ae.ordenador');
//        var_dump($ordem_chegada); die;
        if ($ordem_chegada == 'f') {
            $this->db->orderby('ae.data');
            $this->db->orderby('ae.inicio');
        } else {
//            $this->db->orderby('ae.data');
            $this->db->orderby('ae.data_autorizacao');
        }

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.sala_preparo', 'false');
        $this->db->where('ae.tipo !=', 'CIRURGICO');
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['tipo']) && strlen($args['tipo']) > 0) {
            $this->db->where('ae.tipo', $args['tipo']);
        }
        return $this->db;
    }

    function listarexamesalapreparo2($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ordenador,
                            ae.ativo,
                            ae.data_autorizacao,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            p.nascimento,
                            es.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id', 'left');
        $this->db->join('tb_ambulatorio_laudo ag', 'e.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = e.sala_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = e.tecnico_realizador', 'left');
        $this->db->where('e.situacao', 'EXECUTANDO');
        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.sala_preparo', 't');
        $this->db->where('e.cancelada', 'false');
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('e.sala_id', $args['sala']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        return $this->db;
    }

    function listarexamecaixaespera($grupo_pagamento_id, $args = array()) {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('g.ambulatorio_guia_id,
                            sum(ae.valor_total) as valortotal,
                            sum(ae.valor1) as valorfaturado,
                            p.nome as paciente,
                            g.data_criacao,
                            ae.paciente_id');
        $this->db->from('tb_ambulatorio_guia g');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        if ($grupo_pagamento_id != 0) {
            $this->db->join('tb_procedimento_convenio_pagamento cp', 'cp.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
            $this->db->where("cp.grupo_pagamento_id", $grupo_pagamento_id);
        }
        $this->db->where("c.dinheiro", 't');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.faturado', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }

        return $this->db;
    }

    function listarexamesguia($guia_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.data_faturar,
                            ae.inicio,
                            ae.data_autorizacao,
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
                            ae.faturado,
                            p.nome as paciente,
                            p.nascimento,
                            p.cpf,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            c.nome as convenio,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('ae.guia_id', $guia_id);
        $this->db->orderby('ae.valor_total desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamesguiamatmed($guia_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.data_faturar,
                            ae.inicio,
                            ae.data_autorizacao,
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
                            ae.faturado,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            c.nome as convenio,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
//        $this->db->where('e.cancelada', 'false');
        $this->db->where('ae.guia_id', $guia_id);
        $this->db->orderby('ae.valor_total desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamesguiamanual($paciente_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.data_autorizacao,
                            ag.ambulatorio_guia_id,
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
                            ae.faturado,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            c.nome as convenio,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = ag.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ag.paciente_id', $paciente_id);
        $this->db->where('ag.data_criacao', date("Y-m-d"));
        $this->db->orderby('ae.valor_total desc');
        $return = $this->db->get();
//        var_dump($return->result()); die;
        return $return->result();
    }

    function gravarexamesfaturamentomanual($ambulatorio_guia, $percentual) {
        try {

            $this->db->select('ag.tipo');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
            $this->db->where('pc.procedimento_convenio_id', $_POST['procedimento1']);
            $return = $this->db->get()->result();
            $tipo = $return[0]->tipo;
//            var_dump($return); die;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            $this->db->set('valor', $_POST['valor1']);

            if ($_POST['valortot'] != "") {
                $this->db->set('valor_bruto', $_POST['valortot']);
            }

            $valortotal = $_POST['valor1'] * $_POST['qtde1'];

            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);

            $this->db->set('valor1', $valortotal);
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
            $this->db->set('empresa_id', $_POST['txtempresa']);
            $this->db->set('confirmado', 't');
            $this->db->set('tipo', $tipo);
            $this->db->set('ativo', 'f');
            $this->db->set('realizada', 't');
            if ($_POST['medicoagenda'] != "") {
                $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                $this->db->set('medico_agenda', $_POST['medicoagenda']);
            }
            if ($_POST['crm1'] != "") {
                $this->db->set('medico_solicitante', $_POST['crm1']);
            }
            $this->db->set('faturado', 't');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $ambulatorio_guia);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('data', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))));
            $this->db->set('data_faturar', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))));
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

    function listarguiafaturamentomanualambulatorial($paciente_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ambulatorio_guia_id');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('data_criacao', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))));
        $return = $this->db->get();
        return $return->result();
    }

    function gravarguiamanual($paciente_id) {
//        var_dump($paciente_id);die;
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('tipo', 'EXAME');
        $this->db->set('data_criacao', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))));
        $this->db->set('convenio_id', $_POST['convenio1']);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_guia');
        $ambulatorio_guia_id = $this->db->insert_id();
        return $ambulatorio_guia_id;
    }

    function listarexamemultifuncao($args = array()) {
        $data = date("Y-m-d");
//        $contador = count($args);

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
//        if ($contador == 0) {
//            $this->db->where('ae.data >=', $data);
//        }
        $this->db->where('ae.tipo', 'EXAME');

        if (empty($args['empresa']) || $args['empresa'] == '') {
            $this->db->where('ae.empresa_id', $empresa_id);
        } else {
            $this->db->where('ae.empresa_id', $args['empresa']);
        }

//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['nascimento']) && strlen($args['nascimento']) > 0) {
            $this->db->where('p.nascimento', $args['nascimento']);
        }
        if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
            $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_agenda', $args['medico']);
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }

        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            if ($args['situacao'] == "BLOQUEADO") {
                $this->db->where('ae.bloqueado', 't');
            }
            if ($args['situacao'] == "LIVRE") {
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.situacao', 'LIVRE');
            }
            if ($args['situacao'] == "OK") {
                $this->db->where('ae.situacao', 'OK');
            }
            if ($args['situacao'] == "FALTOU") {
                date_default_timezone_set('America/Fortaleza');
                $data_atual = date('Y-m-d');
                $this->db->where('ae.data <', $data_atual);
                $this->db->where('ae.situacao', 'OK');
                $this->db->where('ae.realizada', 'f');
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.operador_atualizacao is not null');
            }
        }
        return $this->db;
    }

    function listarexamemultifuncao2($args = array()) {
        $data = date("Y-m-d");
        $contador = count($args);

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.operador_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            ae.encaixe,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            e.situacao as situacaoexame,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.codigo,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        if ($contador == 0) {
            $this->db->where('ae.data >=', $data);
        }
        $this->db->where('ae.tipo', 'EXAME');

        if (empty($args['empresa']) || $args['empresa'] == '') {
            $this->db->where('ae.empresa_id', $empresa_id);
        } else {
            $this->db->where('ae.empresa_id', $args['empresa']);
        }

//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['nascimento']) && strlen($args['nascimento']) > 0) {
            $this->db->where('p.nascimento', date("Y-m-d", strtotime(str_replace('/', '-', $args['nascimento']))));
        }
        if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
            $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_agenda', $args['medico']);
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }

        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            if ($args['situacao'] == "BLOQUEADO") {
                $this->db->where('ae.bloqueado', 't');
            }
            if ($args['situacao'] == "LIVRE") {
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.situacao', 'LIVRE');
            }
            if ($args['situacao'] == "OK") {
                $this->db->where('ae.situacao', 'OK');
            }
            if ($args['situacao'] == "FALTOU") {
                date_default_timezone_set('America/Fortaleza');
                $data_atual = date('Y-m-d');
                $this->db->where('ae.data <', $data_atual);
                $this->db->where('ae.situacao', 'OK');
                $this->db->where('ae.realizada', 'f');
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.operador_atualizacao is not null');
            }
        }
        return $this->db;
    }

    function listarexamemultifuncao2calendario($args = array()) {
        $data = date("Y-m-d");
        $contador = count($args);

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.operador_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            ae.encaixe,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            e.situacao as situacaoexame,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.codigo,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        if ($contador == 0) {
            $this->db->where('ae.data >=', $data);
        }
        if ($contador == 0) {
            $this->db->where('ae.data >=', $data);
        }
        $this->db->where('ae.tipo', 'EXAME');

        if (empty($args['empresa']) || $args['empresa'] == '') {
            $this->db->where('ae.empresa_id', $empresa_id);
        } else {
            $this->db->where('ae.empresa_id', $args['empresa']);
        }

//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['nascimento']) && strlen($args['nascimento']) > 0) {
            $this->db->where('p.nascimento', date("Y-m-d", strtotime(str_replace('/', '-', $args['nascimento']))));
        }
        if (isset($args['grupo']) && strlen($args['grupo']) > 0) {
            $this->db->where('an.grupo', $args['grupo']);
        }
        if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
            $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_agenda', $args['medico']);
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        } else {
            $this->db->where('ae.data', date("Y-m-d"));
        }
//        var_dump($args['sala']); die;
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }

        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            if ($args['situacao'] == "BLOQUEADO") {
                $this->db->where('ae.bloqueado', 't');
            }
            if ($args['situacao'] == "LIVRE") {
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.situacao', 'LIVRE');
            }
            if ($args['situacao'] == "OK") {
                $this->db->where('ae.situacao', 'OK');
            }
            if ($args['situacao'] == "FALTOU") {
                date_default_timezone_set('America/Fortaleza');
                $data_atual = date('Y-m-d');
                $this->db->where('ae.data <', $data_atual);
                $this->db->where('ae.situacao', 'OK');
                $this->db->where('ae.realizada', 'f');
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.operador_atualizacao is not null');
            }
        }
        return $this->db;
    }

    function buscarmedicotroca($agenda_exames_id) {
        $this->db->select('o.nome as medicoagenda');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->where('ae.agenda_exames_id', $agenda_exames_id);

        $return = $this->db->get();
        return $return->result();
    }

    function buscarmedicotrocaconsulta($agenda_exames_id) {
        $this->db->select('o.nome as medicoagenda');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.agenda_exames_id', $agenda_exames_id);

        $return = $this->db->get();
        return $return->result();
    }

    function trocarmedico() {

        try {
            if ($_POST['tipo'] == 1) {
                $this->db->set('medico_agenda', $_POST['medico2']);
                $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
                $this->db->update('tb_agenda_exames');
            } elseif ($_POST['tipo'] == 2) {
                $this->db->set('medico_consulta_id', $_POST['medico2']);
                $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
                $this->db->update('tb_agenda_exames');
            }
            $erro = $this->db->_error_message();

            $this->db->select('exames_id');
            $this->db->from('tb_exames');
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $return = $this->db->get();
            $result = $return->result();

            if (isset($result[0]->exames_id)) {
                $this->db->set('medico_parecer1', $_POST['medico2']);
                $this->db->where('exame_id', $result[0]->exames_id);
                $this->db->update('tb_ambulatorio_laudo');
            }
            if ($erro != '') {
                return false;
            } else {
                return true;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    function listarexamemultifuncaogeral($args = array()) {
        $data = date("Y-m-d");
        $contador = count($args);

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.ocupado,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.operador_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            e.situacao as situacaoexame,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            ae.medico_agenda,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.codigo,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador,
                            bloc.nome as operador_bloqueio,
                            desbloc.nome as operador_desbloqueio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->join('tb_operador bloc', 'bloc.operador_id = ae.operador_bloqueio', 'left');
        $this->db->join('tb_operador desbloc', 'desbloc.operador_id = ae.operador_desbloqueio', 'left');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
        if ($contador == 0) {
            $this->db->where('ae.data >=', $data);
        }
        if (empty($args['empresa']) || $args['empresa'] == '') {
            $this->db->where('ae.empresa_id', $empresa_id);
        } else {
            $this->db->where('ae.empresa_id', $args['empresa']);
        }
//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['nascimento']) && strlen($args['nascimento']) > 0) {
            $this->db->where('p.nascimento', $args['nascimento']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
            $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            if ($args['situacao'] == "BLOQUEADO") {
                $this->db->where('ae.bloqueado', 't');
            }
            if ($args['situacao'] == "LIVRE") {
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.situacao', 'LIVRE');
            }
            if ($args['situacao'] == "OK") {
                $this->db->where('ae.situacao', 'OK');
            }
            if ($args['situacao'] == "FALTOU") {
                date_default_timezone_set('America/Fortaleza');
                $data_atual = date('Y-m-d');
                $this->db->where('ae.data <', $data_atual);
                $this->db->where('ae.situacao', 'OK');
                $this->db->where('ae.realizada', 'f');
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.operador_atualizacao is not null');
            }
        }
        if (isset($args['c_s_medico']) && strlen($args['c_s_medico']) > 0) {
            $this->db->where('pt.medico', $args['c_s_medico']);
        }
        if (isset($args['c_s_medico']) && strlen($args['c_s_medico']) > 0) {
            $this->db->where('pt.medico', $args['c_s_medico']);
        }
        return $this->db;
    }

    function listarexamemultifuncaogeral2($args = array()) {
        $data = date("Y-m-d");
        $contador = count($args);

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.ocupado,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.operador_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            ae.encaixe,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            e.situacao as situacaoexame,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            ae.medico_agenda,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.codigo,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador,
                            bloc.nome as operador_bloqueio,
                            desbloc.nome as operador_desbloqueio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->join('tb_operador bloc', 'bloc.operador_id = ae.operador_bloqueio', 'left');
        $this->db->join('tb_operador desbloc', 'desbloc.operador_id = ae.operador_desbloqueio', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        if ($contador == 0) {
            $this->db->where('ae.data >=', $data);
        }
        if (empty($args['empresa']) || $args['empresa'] == '') {
            $this->db->where('ae.empresa_id', $empresa_id);
        } else {
            $this->db->where('ae.empresa_id', $args['empresa']);
        }
//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['nascimento']) && strlen($args['nascimento']) > 0) {
            $this->db->where('p.nascimento', $args['nascimento']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
            $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            if ($args['situacao'] == "BLOQUEADO") {
                $this->db->where('ae.bloqueado', 't');
            }
            if ($args['situacao'] == "LIVRE") {
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.situacao', 'LIVRE');
            }
            if ($args['situacao'] == "OK") {
                $this->db->where('ae.situacao', 'OK');
            }
            if ($args['situacao'] == "FALTOU") {
                date_default_timezone_set('America/Fortaleza');
                $data_atual = date('Y-m-d');
                $this->db->where('ae.data <', $data_atual);
                $this->db->where('ae.situacao', 'OK');
                $this->db->where('ae.realizada', 'f');
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.operador_atualizacao is not null');
            }
        }
        if (isset($args['c_s_medico']) && strlen($args['c_s_medico']) > 0) {
            $this->db->where('pt.medico', $args['c_s_medico']);
        }
        if (isset($args['c_s_medico']) && strlen($args['c_s_medico']) > 0) {
            $this->db->where('pt.medico', $args['c_s_medico']);
        }
        return $this->db;
    }

    function listarestatisticapaciente($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'EXAME');
//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarestatisticapacienteespecialidade($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'FISIOTERAPIA');
//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarestatisticapacienteconsulta($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'CONSULTA');
//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarestatisticasempaciente($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'LIVRE');
        $this->db->where('ae.tipo', 'EXAME');
//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarestatisticasempacienteespecialidade($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'LIVRE');
        $this->db->where('ae.tipo', 'FISIOTERAPIA');
//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarestatisticasempacienteconsulta($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.realizada,
                            ae.confirmado,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->where('ae.data >=', $data);
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'LIVRE');
        $this->db->where('ae.tipo', 'CONSULTA');
//        $this->db->limit(5);
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarexamemultifuncaoconsulta($args = array()) {
        $data = date("Y-m-d");
//        $contador = count($args);
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
                            ae.operador_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            ae.encaixe,
                            ae.procedimento_tuss_id,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            e.situacao as situacaoexame,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
//        if ($contador == 0) {
//            $this->db->where('ae.data >=', $data);
//        }
//        $this->db->where('ae.data >=', $data);
        if (empty($args['empresa']) || $args['empresa'] == '') {
            $this->db->where('ae.empresa_id', $empresa_id);
        } else {
            $this->db->where('ae.empresa_id', $args['empresa']);
        }
        $this->db->where('ae.tipo', 'CONSULTA');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
            $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            if ($args['situacao'] == "BLOQUEADO") {
                $this->db->where('ae.bloqueado', 't');
            }
            if ($args['situacao'] == "LIVRE") {
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.situacao', 'LIVRE');
            }
            if ($args['situacao'] == "OK") {
                $this->db->where('ae.situacao', 'OK');
            }
            if ($args['situacao'] == "FALTOU") {
                date_default_timezone_set('America/Fortaleza');
                $data_atual = date('Y-m-d');
                $this->db->where('ae.data <', $data_atual);
                $this->db->where('ae.situacao', 'OK');
                $this->db->where('ae.realizada', 'f');
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.operador_atualizacao is not null');
            }
        }
        return $this->db;
    }

    function listarexamemultifuncaoconsulta2($args = array()) {
        $data = date("Y-m-d");
        $contador = count($args);
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
                            ae.operador_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            ae.encaixe,
                            ae.chegada,
                            ae.procedimento_tuss_id,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            e.situacao as situacaoexame,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        if ($contador == 0) {
            $this->db->where('ae.data >=', $data);
        }
//        $this->db->where('ae.data >=', $data);
        if (empty($args['empresa']) || $args['empresa'] == '') {
            $this->db->where('ae.empresa_id', $empresa_id);
        } else {
            $this->db->where('ae.empresa_id', $args['empresa']);
        }
        $this->db->where('ae.tipo', 'CONSULTA');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
            $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            if ($args['situacao'] == "BLOQUEADO") {
                $this->db->where('ae.bloqueado', 't');
            }
            if ($args['situacao'] == "LIVRE") {
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.situacao', 'LIVRE');
            }
            if ($args['situacao'] == "OK") {
                $this->db->where('ae.situacao', 'OK');
            }
            if ($args['situacao'] == "FALTOU") {
                date_default_timezone_set('America/Fortaleza');
                $data_atual = date('Y-m-d');
                $this->db->where('ae.data <', $data_atual);
                $this->db->where('ae.situacao', 'OK');
                $this->db->where('ae.realizada', 'f');
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.operador_atualizacao is not null');
            }
        }
        return $this->db;
    }

    function gerarelatoriomedicoagendaexamefaltou($args = array()) {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            p.celular,
                            p.telefone,
                            p.nome as paciente,
                            pt.nome as procedimento,
                            m.nome as cidade,
                            ae.data
                            ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_municipio m', 'p.municipio_id = m.municipio_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        date_default_timezone_set('America/Fortaleza');
        $data_atual = date('Y-m-d');
        $this->db->where('ae.data >=', $_POST['txtdata_inicio']);
        $this->db->where('ae.data <=', $_POST['txtdata_fim']);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.realizada', 'f');
        $this->db->where('ae.paciente_id is not null');
        $this->db->where('(ae.numero_sessao >= 1) IS NOT TRUE');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        if ($_POST['empresa'] != '') {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['medicos'] != '') {
            $this->db->where('ae.medico_agenda', $_POST['medicos']);
        }


        $return = $this->db->get();
        return $return->result();
    }

    function gerarelatorioorcamentos($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select(' ao.ambulatorio_orcamento_id,
                            p.nome as paciente,
                            p.celular,
                            p.telefone,
                            ao.data_criacao,
                            e.nome as empresa_nome,
                            (
                                SELECT SUM(valor_total)
                                FROM ponto.tb_ambulatorio_orcamento_item
                                WHERE ponto.tb_ambulatorio_orcamento_item.orcamento_id = ao.ambulatorio_orcamento_id
                            ) as valor');
        $this->db->from('tb_ambulatorio_orcamento ao');
        $this->db->join('tb_paciente p', 'p.paciente_id = ao.paciente_id', 'left');
        $this->db->join('tb_empresa e', 'e.empresa_id = ao.empresa_id', 'left');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ao.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ao.data_criacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ao.data_criacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('ao.data_criacao');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendamentoteleoperadora($args = array()) {
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
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['medicos'] != '') {
            $this->db->where('ae.operador_atualizacao', $_POST['medicos']);
        }

        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaconsulta($args = array()) {
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
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->where('ae.tipo', 'CONSULTA');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['medicos'] != '') {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }

        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaespecialidade($args = array()) {
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
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->where("(ae.tipo = 'FISIOTERAPIA' OR ae.tipo = 'ESPECIALIDADE')");
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['medicos'] != '') {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }

        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaordem($args = array()) {
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
                            ae.valor_total,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            p.celular,
                            ae.bloqueado,
                            p.telefone,
                            c.nome as convenio,
                            o.nome as medicoagenda,
                            an.nome as sala,
                            tc.descricao as tipoconsulta,
                            p.nome as paciente,
                            f.nome as forma_pagamento,
                            op.nome as secretaria,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.perc_medico,
                            pt.percentual,
                            pc.valortotal,
                            al.medico_parecer1,
                            pt.procedimento_tuss_id as procedimento_tuss_id_novo, 
                            c.dinheiro,
                            al.situacao as situacaolaudo,
                            ae.ordenador ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('pt.nome');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.ordenador', null);
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }
        if ($_POST['hora_inicio'] != "" && $_POST['hora_fim'] != "") {
            $this->db->where('ae.inicio >=', $_POST['hora_inicio']);
            $this->db->where('ae.inicio <=', $_POST['hora_fim']);
        }
        if ($_POST['procedimentos'] != "0") {
            $this->db->where('pt.procedimento_tuss_id', $_POST['procedimentos']);
        }
        if ($_POST['salas'] != "0") {
            $this->db->where('an.exame_sala_id', $_POST['salas']);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaordemprioridade($args = array()) {
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
                            ae.valor_total,
                            ae.confirmado,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
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
                            f.nome as forma_pagamento,
                            pt.nome as procedimento,
                            pt.percentual,
                            pt.procedimento_tuss_id as procedimento_tuss_id_novo,
                            pt.perc_medico,
                            pc.valortotal,
                            c.dinheiro,
                            al.situacao as situacaolaudo,
                            al.medico_parecer1,
                            ae.ordenador ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.ordenador');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.ordenador is not null');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_consulta_id', $_POST['medicos']);
        }
        if ($_POST['hora_inicio'] != "" && $_POST['hora_fim'] != "") {
            $this->db->where('ae.inicio >=', $_POST['hora_inicio']);
            $this->db->where('ae.inicio <=', $_POST['hora_fim']);
        }
        if ($_POST['procedimentos'] != "0") {
            $this->db->where('pt.procedimento_tuss_id', $_POST['procedimentos']);
        }
        if ($_POST['salas'] != "0") {
            $this->db->where('an.exame_sala_id', $_POST['salas']);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaexame($args = array()) {
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
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->where('ae.tipo', 'EXAME');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['medicos'] != "") {
            $this->db->where('ae.medico_agenda', $_POST['medicos']);
        }
        if ($_POST['salas'] != "0") {
            $this->db->where('ae.agenda_exames_nome_id', $_POST['salas']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));


        $return = $this->db->get();
        return $return->result();
    }

    function listarexamemultifuncaofisioterapia($args = array()) {
        $contador = count($args);
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
                            ae.operador_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            ae.observacoes,
                            ae.encaixe,
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
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio ca', 'ca.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->join('tb_agrupador_fisioterapia_temp aft', 'aft.agrupador_fisioterapia_temp_id = ae.agrupador_fisioterapia', 'left');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
        if ($contador == 0) {
            $this->db->where('ae.data >=', $data);
        }
        $this->db->where('((numero_sessao is null OR numero_sessao = 1) OR (aft.agrupador_fisioterapia_temp_id is not null) OR (confirmado = true))');
//        $this->db->where('numero_sessao', null);
        $this->db->where("( (ae.tipo = 'FISIOTERAPIA') OR (ae.tipo = 'ESPECIALIDADE') )");

        if (empty($args['empresa']) || $args['empresa'] == '') {
            $this->db->where('ae.empresa_id', $empresa_id);
        } else {
            $this->db->where('ae.empresa_id', $args['empresa']);
        }
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
            $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            if ($args['situacao'] == "BLOQUEADO") {
                $this->db->where('ae.bloqueado', 't');
            }
            if ($args['situacao'] == "LIVRE") {
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.situacao', 'LIVRE');
            }
            if ($args['situacao'] == "OK") {
                $this->db->where('ae.situacao', 'OK');
            }
            if ($args['situacao'] == "FALTOU") {
                date_default_timezone_set('America/Fortaleza');
                $data_atual = date('Y-m-d');
                $this->db->where('ae.data <', $data_atual);
                $this->db->where('ae.situacao', 'OK');
                $this->db->where('ae.realizada', 'f');
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.operador_atualizacao is not null');
            }
        }
        return $this->db;
    }

    function listarexamemultifuncaofisioterapia2($args = array()) {
        $contador = count($args);
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
                            ae.medico_agenda,
                            ae.operador_atualizacao,
                            ae.paciente_id,
                            ae.telefonema,
                            e.situacao as situacaoexame,
                            ae.observacoes,
                            ae.encaixe,
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
                            al.situacao as situacaolaudo,
                            tel.nome as telefonema_operador');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
        $this->db->join('tb_agrupador_fisioterapia_temp aft', 'aft.agrupador_fisioterapia_temp_id = ae.agrupador_fisioterapia', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        if ($contador == 0) {
            $this->db->where('ae.data >=', $data);
        }
        $this->db->where('((numero_sessao is null OR numero_sessao = 1) OR (aft.agrupador_fisioterapia_temp_id is not null) OR (confirmado = true))');
//        $this->db->where('numero_sessao', null);
        $this->db->where("( (ae.tipo = 'FISIOTERAPIA') OR (ae.tipo = 'ESPECIALIDADE') )");

        if (empty($args['empresa']) || $args['empresa'] == '') {
            $this->db->where('ae.empresa_id', $empresa_id);
        } else {
            $this->db->where('ae.empresa_id', $args['empresa']);
        }
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
//        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
            $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_consulta_id', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            if ($args['situacao'] == "BLOQUEADO") {
                $this->db->where('ae.bloqueado', 't');
            }
            if ($args['situacao'] == "LIVRE") {
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.situacao', 'LIVRE');
            }
            if ($args['situacao'] == "OK") {
                $this->db->where('ae.situacao', 'OK');
            }
            if ($args['situacao'] == "FALTOU") {
                date_default_timezone_set('America/Fortaleza');
                $data_atual = date('Y-m-d');
                $this->db->where('ae.data <', $data_atual);
                $this->db->where('ae.situacao', 'OK');
                $this->db->where('ae.realizada', 'f');
                $this->db->where('ae.bloqueado', 'f');
                $this->db->where('ae.operador_atualizacao is not null');
            }
        }
        return $this->db;
    }

    function listarhorariosreagendamento() {
        $data = date("Y-m-d");
        $this->db->select('ae.paciente_id,
                           ae.agenda_exames_id,
                           ae.procedimento_tuss_id,
                           ae.inicio,
                           ae.fim,
                           ae.medico_agenda,
                           ae.tipo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where('(numero_sessao is null OR numero_sessao = 1)');
        if ($_POST['tipoRelatorio'] == "CONSULTA" || $_POST['tipoRelatorio'] == "EXAME") {
            $this->db->where("ae.tipo", $_POST['tipoRelatorio']);
        } else {
            $this->db->where("( (ae.tipo = 'FISIOTERAPIA') OR (ae.tipo = 'ESPECIALIDADE') )");
        }
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.empresa_id', $_POST['empresa']);
        $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where('ae.medico_agenda', $_POST['medicos']);
        $this->db->where('ae.paciente_id IS NOT NULL');


        $return = $this->db->get();
        return $return->result();
    }

    function listarhorariosreagendamentoespecialidade() {
        $r = 0;
        echo '<pre>';
        $horarios = '';
        foreach ($_POST['agenda_exames_id'] as $item) {
            $r++;
            $confirmado = $_POST['reagendar'][$r];
            $agenda_exames_id = $_POST['agenda_exames_id'][$r];
            if ($confirmado == 'on') {
                if ($horarios == '') {
                    $horarios = $horarios . "$agenda_exames_id";
                } else {
                    $horarios = $horarios . ",$agenda_exames_id";
                }
            }
        }

//        $data = date("Y-m-d");
        $this->db->select('ae.paciente_id,
                           ae.agenda_exames_id,
                           ae.procedimento_tuss_id,
                           ae.inicio,
                           ae.data,
                           ae.fim,
                           ae.medico_agenda,
                           p.nome as paciente,
                           ae.empresa_id,
                           ae.tipo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');

        $this->db->where("ae.agenda_exames_id IN ($horarios)");

        $return = $this->db->get();
        return $return->result();
    }

    function gravareagendamento($agenda) {
        $return = array();

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        foreach ($agenda as $item) {

            $this->db->select('ae.agenda_exames_id');
            $this->db->from('tb_agenda_exames ae');
            if ($item->tipo == "CONSULTA" || $item->tipo == "EXAME") {
                $this->db->where("ae.tipo", $item->tipo);
            } else {
                $this->db->where("( (ae.tipo = 'FISIOTERAPIA') OR (ae.tipo = 'ESPECIALIDADE') )");
            }
            $this->db->where('ae.empresa_id', $_POST['empresa']);
            $this->db->where('ae.realizada', 'false');
            $this->db->where('ae.inicio', $item->inicio);
            $this->db->where('ae.fim ', $item->fim);
            $this->db->where('ae.cancelada', 'false');
            $this->db->where('ae.bloqueado', 'f');
            $this->db->where('ae.situacao', 'LIVRE');
            $this->db->where('ae.paciente_id IS NULL');
            $this->db->where('ae.procedimento_tuss_id IS NULL');
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
            $this->db->where('ae.medico_agenda', $_POST['medicos']);
            $retorno = $this->db->get()->result();
//            var_dump($retorno);die;

            if (count($retorno) > 0) {
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('paciente_id', $item->paciente_id);
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('medico_consulta_id', $item->medico_agenda);
                $this->db->set('medico_agenda', $item->medico_agenda);
                if ($item->procedimento_tuss_id != '') {
                    $this->db->set('procedimento_tuss_id', $item->procedimento_tuss_id);
                }
                $this->db->set('situacao', 'OK');
                if ($item->tipo != '') {
                    $this->db->set('tipo', $item->tipo);
                }
                $this->db->where('agenda_exames_id', $retorno[0]->agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            } else {
//                die;
                $return[] = $item->agenda_exames_id;
            }
        }
        return $return;
    }

    function gravareagendamentoespecialidade($agenda) {
        $return = array();

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
//        $operador_id = $this->session->userdata('operador_id');

        foreach ($agenda as $item) {

            $this->db->select('ae.agenda_exames_id');
            $this->db->from('tb_agenda_exames ae');
            if ($item->tipo == "CONSULTA" || $item->tipo == "EXAME") {
                $this->db->where("ae.tipo", $item->tipo);
            } else {
                $this->db->where("( (ae.tipo = 'FISIOTERAPIA') OR (ae.tipo = 'ESPECIALIDADE') )");
            }
//            $this->db->where('ae.empresa_id', $item->empresa_id);
            $this->db->where('ae.realizada', 'false');
            $this->db->where('ae.inicio', $item->inicio);
//            $this->db->where('ae.fim ', $item->fim);
            $this->db->where('ae.cancelada', 'false');
            $this->db->where('ae.bloqueado', 'f');
//            $this->db->where('ae.situacao', 'LIVRE');
            $this->db->where('ae.paciente_id IS NULL');
            $this->db->where('ae.procedimento_tuss_id IS NULL');
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_reagendar']))));
            $this->db->where('ae.medico_agenda', $item->medico_agenda);
            $retorno = $this->db->get()->result();
//            var_dump($retorno);die;

            if (count($retorno) > 0) {
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('paciente_id', $item->paciente_id);
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 'f');
                $this->db->set('medico_consulta_id', $item->medico_agenda);
                $this->db->set('medico_agenda', $item->medico_agenda);
                if ($item->procedimento_tuss_id != '') {
                    $this->db->set('procedimento_tuss_id', $item->procedimento_tuss_id);
                }
                $this->db->set('situacao', 'OK');
                if ($item->tipo != '') {
                    $this->db->set('tipo', $item->tipo);
                }
                $this->db->where('agenda_exames_id', $retorno[0]->agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            } else {
//                die;
                $return[] = $item->paciente;
            }
        }
        return $return;
    }

    function autorizarsessaofisioterapia($paciente_id) {
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
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('pc.procedimento_convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.numero_sessao');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.paciente_id', $paciente_id);
        $this->db->where("( (ae.tipo = 'FISIOTERAPIA') OR (ae.tipo = 'ESPECIALIDADE') )");
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.guia_id is not null');
        $this->db->where('ae.numero_sessao >=', '1');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.confirmado', 'false');
        $this->db->where('ae.cancelada', 'false');
        $return = $this->db->get();
        return $return->result();
    }

    function autorizarsessaopsicologia($paciente_id) {
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
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.numero_sessao');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.paciente_id', $paciente_id);
        $this->db->where('ae.tipo', 'PSICOLOGIA');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.numero_sessao >=', '1');
        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.confirmado', 'false');
        $this->db->where('ae.cancelada', 'false');
        $return = $this->db->get();
        return $return->result();
    }

    function listarmultifuncaomedico($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where("( (ag.tipo = 'EXAME') OR (ae.tipo = 'EXAME' AND ae.procedimento_tuss_id IS NULL) )");
//        $this->db->orderby('ae.procedimento_tuss_id');
//        $this->db->where('pt.grupo !=', 'LABORATORIAL');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');

        if ($perfil_id == 4) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
        }

        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['txtCICPrimario']) && strlen($args['txtCICPrimario']) > 0) {
            $this->db->where('al.cid ilike', "%" . $args['txtCICPrimario'] . "%");
//                $this->db->orwhere('al.cid2 ilike', "%" . $args['txtCICPrimario'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['prontuario']) && strlen($args['prontuario']) > 0) {
            $this->db->where('p.paciente_id', $args['prontuario']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        } if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_agenda', $args['medico']);
        }
        return $this->db->get()->result();
    }

    function listarmultifuncao2medico($args = array(), $ordem_chegada) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $perfil_id = $this->session->userdata('perfil_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.data_autorizacao,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            e.situacao as situacaoexame,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            pt.grupo,
                            ae.bloqueado,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where("( (ag.tipo = 'EXAME') OR (ae.tipo = 'EXAME' AND ae.procedimento_tuss_id IS NULL) )");
//        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where('pt.grupo !=', 'LABORATORIAL');
        $this->db->where('ae.sala_preparo', 'f');
//        $this->db->orderby('ae.procedimento_tuss_id');
        $this->db->orderby('ae.data');
        if ($ordem_chegada == 't') {
            $this->db->orderby('ae.data_autorizacao');
        } else {
            $this->db->orderby('ae.inicio');
        }
//        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
//        if ((!isset($args['nome'])&& $args['nome'] == 0) || (!isset($args['data'])&& strlen($args['data']) == '') || (!isset($args['sala'])&& strlen($args['sala']) == '') || (!isset($args['medico'])&& strlen($args['medico']) =='')) {
            $this->db->where('ae.medico_agenda', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if ($perfil_id == 4) {
                $this->db->where('ae.medico_agenda', $operador_id);
            }
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['txtCICPrimario']) && strlen($args['txtCICPrimario']) > 0) {
                $this->db->where('al.cid ilike', "%" . $args['txtCICPrimario'] . "%");
//                $this->db->orwhere('al.cid2 ilike', "%" . $args['txtCICPrimario'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['prontuario']) && strlen($args['prontuario']) > 0) {
                $this->db->where('p.paciente_id', $args['prontuario']);
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_agenda', $args['medico']);
            }
            if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
                $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
            }
        }
        return $this->db;
    }

    function listarmultifuncaomedicolaboratorial($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('pt.grupo', 'LABORATORIAL');
//        $this->db->where('pt.grupo !=', 'CONSULTA');
//        $this->db->where('pt.grupo !=', 'LABORATORIAL');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ae.situacao', $args['situacao']);
        } if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ae.medico_agenda', $args['medico']);
        }
        return $this->db;
    }

    function listarmultifuncao2medicolaboratorial($args = array()) {


        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            pt.grupo,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('pt.grupo', 'LABORATORIAL');
//        $this->db->where('pt.grupo !=', 'CONSULTA');
//        $this->db->where('pt.grupo !=', 'LABORATORIAL');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
//        if ((!isset($args['nome'])&& $args['nome'] == 0) || (!isset($args['data'])&& strlen($args['data']) == '') || (!isset($args['sala'])&& strlen($args['sala']) == '') || (!isset($args['medico'])&& strlen($args['medico']) =='')) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncaoconsulta($args = array()) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id
                            ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where("( (ag.tipo = 'CONSULTA') OR (ae.tipo = 'CONSULTA' AND ae.procedimento_tuss_id IS NULL) )");
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
//        $this->db->orderby('al.situacao');
        $this->db->where('ae.cancelada', 'false');
//        if ($operador_id != '1') {
//            
//        }


        if ($teste == true) {
            $this->db->where('ae.data', $dataAtual);
            $this->db->where('ae.medico_consulta_id', $operador_id);
        } else {

            if ($perfil_id == 4) {
                $this->db->where('ae.medico_consulta_id', $operador_id);
            }

            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['txtCICPrimario']) && strlen($args['txtCICPrimario']) > 0) {
                $this->db->where('al.cid ilike', "%" . $args['txtCICPrimario'] . "%");
//                $this->db->orwhere('al.cid2 ilike', "%" . $args['txtCICPrimario'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncaogeral($args = array()) {
        $teste = empty($args);
        $empresa_id = $this->session->userdata('empresa_id');
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');
        $dataAtual = date("Y-m-d");
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            o.nome as medicoconsulta,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_tuss t', 't.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_tuss_classificacao tc', 'tc.tuss_classificacao_id = t.classificacao', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.tipo !=', 'CIRURGICO');
        if ($teste == true) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if ($perfil_id == 4) {
                $this->db->where('ae.medico_consulta_id', $operador_id);
            }
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['txtCICPrimario']) && strlen($args['txtCICPrimario']) > 0) {
                $this->db->where('al.cid ilike', "%" . $args['txtCICPrimario'] . "%");
//                $this->db->orwhere('al.cid2 ilike', "%" . $args['txtCICPrimario'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
//                if ($args['situacao'] != 'FALTOU') {
//                    $this->db->where('ae.situacao', $args['situacao']);
//                } //else {
//                    date_default_timezone_set('America/Fortaleza');
//                    $data_atual = date('Y-m-d');
//                    $hora_atual = date('H:i:s');
//                    $this->db->where('ae.data <=', $data_atual);
//                    $this->db->where('ae.inicio <=', $hora_atual);
//                }
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncao2consulta($args = array(), $ordem_chegada) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.data_autorizacao,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            o.nome as medicoconsulta,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            e.exames_id,
                            e.situacao as situacaoexame,
                            e.sala_id,                            
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where("( (ag.tipo = 'CONSULTA') OR (ae.tipo = 'CONSULTA' AND ae.procedimento_tuss_id IS NULL) )");
        $this->db->orderby('ae.data');
        if ($ordem_chegada == 't') {
            $this->db->orderby('ae.data_autorizacao');
        } else {
            $this->db->orderby('ae.inicio');
        }
        $this->db->orderby('ae.inicio');
        $this->db->orderby('al.situacao');
        $this->db->where('ae.cancelada', 'false');

        if ($teste == true) {
            $this->db->where('ae.data', $dataAtual);
            $this->db->where('ae.medico_consulta_id', $operador_id);
        } else {
            if ($perfil_id == 4) {
                $this->db->where('ae.medico_consulta_id', $operador_id);
            }
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['txtCICPrimario']) && strlen($args['txtCICPrimario']) > 0) {
                $this->db->where('al.cid ilike', "%" . $args['txtCICPrimario'] . "%");
//                $this->db->orwhere('al.cid2 ilike', "%" . $args['txtCICPrimario'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
            if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
                $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
            }
        }
        return $this->db;
    }

    function listarmultifuncao2geral($args = array(), $ordem_chegada) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.data_autorizacao,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            o.nome as medicoconsulta,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            e.exames_id,
                            e.sala_id,
                            pt.grupo,
                            c.nome as convenio,
                            co.nome as convenio_paciente,
                            pt.nome as procedimento,
                            tc.nome as classificacao,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_tuss t', 't.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_tuss_classificacao tc', 'tc.tuss_classificacao_id = t.classificacao', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->orderby('ae.data');
        if ($ordem_chegada == 't') {
            $this->db->orderby('ae.data_autorizacao');
        } else {
            $this->db->orderby('ae.inicio');
        }
        $this->db->orderby('ae.inicio');
        $this->db->orderby('al.situacao');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.tipo !=', 'CIRURGICO');
        if ($teste == true) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if ($perfil_id == 4) {
                $this->db->where('ae.medico_consulta_id', $operador_id);
            }
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['txtCICPrimario']) && strlen($args['txtCICPrimario']) > 0) {
                $this->db->where('al.cid ilike', "%" . $args['txtCICPrimario'] . "%");
//                $this->db->orwhere('al.cid2 ilike', "%" . $args['txtCICPrimario'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            } if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncaofisioterapiareagendar($args = array()) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.paciente_id is not null');
//        $this->db->where('ae.confirmado', 't');
        $this->db->where("( (ag.tipo = 'ESPECIALIDADE') OR ( (ae.tipo = 'FISIOTERAPIA' OR ae.tipo = 'ESPECIALIDADE') AND ae.procedimento_tuss_id IS NULL) )");
//        $this->db->orderby('ae.realizada', 'desc');
//        $this->db->orderby('al.situacao');
//        $this->db->orderby('ae.data_autorizacao');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');

        if ($teste == true) {
            $this->db->where('ae.data', $dataAtual);
            $this->db->where('ae.medico_consulta_id', $operador_id);
        } else {
            if ($perfil_id == 4) {
                $this->db->where('ae.medico_consulta_id', $operador_id);
            }

            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['txtCICPrimario']) && strlen($args['txtCICPrimario']) > 0) {
                $this->db->where('al.cid ilike', "%" . $args['txtCICPrimario'] . "%");
//                $this->db->orwhere('al.cid2 ilike', "%" . $args['txtCICPrimario'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                if ($args['situacao'] == "BLOQUEADO") {
                    $this->db->where('ae.bloqueado', 't');
                }
                if ($args['situacao'] == "LIVRE") {
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.situacao', 'LIVRE');
                }
                if ($args['situacao'] == "OK") {
                    $this->db->where('ae.situacao', 'OK');
                }
                if ($args['situacao'] == "FALTOU") {
                    date_default_timezone_set('America/Fortaleza');
                    $data_atual = date('Y-m-d');
                    $this->db->where('ae.data <', $data_atual);
                    $this->db->where('ae.situacao', 'OK');
                    $this->db->where('ae.realizada', 'f');
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.operador_atualizacao is not null');
                }
            }
        }
        return $this->db;
    }

    function listarmultifuncao2fisioterapiareagendar($args = array()) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.data_autorizacao,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.bloqueado,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            ae.agenda_exames_nome_id,
                            an.nome as sala,
                            o.nome as medicoconsulta,
                            p.nome as paciente,
                            p.telefone,
                            p.celular,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            c.nome as convenio,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.paciente_id is not null');
//        $this->db->where('ae.confirmado', 't');
        $this->db->where("( (ag.tipo = 'ESPECIALIDADE') OR ( (ae.tipo = 'FISIOTERAPIA' OR ae.tipo = 'ESPECIALIDADE') AND ae.procedimento_tuss_id IS NULL) )");
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->orderby('ae.realizada', 'desc');
        $this->db->orderby('al.situacao');
        $this->db->orderby('ae.data_autorizacao');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
            $this->db->where('ae.data', $dataAtual);
            $this->db->where('ae.medico_consulta_id', $operador_id);
        } else {
            if ($perfil_id == 4) {
                $this->db->where('ae.medico_consulta_id', $operador_id);
            }
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['txtCICPrimario']) && strlen($args['txtCICPrimario']) > 0) {
                $this->db->where('al.cid ilike', "%" . $args['txtCICPrimario'] . "%");
//                $this->db->orwhere('al.cid2 ilike', "%" . $args['txtCICPrimario'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
            if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
                $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                if ($args['situacao'] == "BLOQUEADO") {
                    $this->db->where('ae.bloqueado', 't');
                }
                if ($args['situacao'] == "LIVRE") {
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.situacao', 'LIVRE');
                }
                if ($args['situacao'] == "OK") {
                    $this->db->where('ae.situacao', 'OK');
                }
                if ($args['situacao'] == "FALTOU") {
                    date_default_timezone_set('America/Fortaleza');
                    $data_atual = date('Y-m-d');
                    $this->db->where('ae.data <', $data_atual);
                    $this->db->where('ae.situacao', 'OK');
                    $this->db->where('ae.realizada', 'f');
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.operador_atualizacao is not null');
                }
            }
        }
        return $this->db;
    }

    function listarmultifuncaoodontologia($args = array()) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
//        $this->db->where('ae.confirmado', 't');
        $this->db->where("( (ag.tipo = 'ESPECIALIDADE') OR ( (ae.tipo = 'FISIOTERAPIA' OR ae.tipo = 'ESPECIALIDADE') AND ae.procedimento_tuss_id IS NULL) )");
//        $this->db->orderby('ae.realizada', 'desc');
//        $this->db->orderby('al.situacao');
//        $this->db->orderby('ae.data_autorizacao');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');

        if ($teste == true) {
            $this->db->where('ae.data', $dataAtual);
            $this->db->where('ae.medico_consulta_id', $operador_id);
        } else {
            if ($perfil_id == 4) {
                $this->db->where('ae.medico_consulta_id', $operador_id);
            }

            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['txtCICPrimario']) && strlen($args['txtCICPrimario']) > 0) {
                $this->db->where('al.cid ilike', "%" . $args['txtCICPrimario'] . "%");
//                $this->db->orwhere('al.cid2 ilike', "%" . $args['txtCICPrimario'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                if ($args['situacao'] == "BLOQUEADO") {
                    $this->db->where('ae.bloqueado', 't');
                }
                if ($args['situacao'] == "LIVRE") {
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.situacao', 'LIVRE');
                }
                if ($args['situacao'] == "OK") {
                    $this->db->where('ae.situacao', 'OK');
                }
                if ($args['situacao'] == "FALTOU") {
                    date_default_timezone_set('America/Fortaleza');
                    $data_atual = date('Y-m-d');
                    $this->db->where('ae.data <', $data_atual);
                    $this->db->where('ae.situacao', 'OK');
                    $this->db->where('ae.realizada', 'f');
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.operador_atualizacao is not null');
                }
            }
        }
        return $this->db;
    }

    function listarmultifuncao2odontologia($args = array()) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.data_autorizacao,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.encaixe,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.bloqueado,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            e.situacao as situacaoexame,
                            p.paciente_id,
                            ae.agenda_exames_nome_id,
                            an.nome as sala,
                            o.nome as medicoconsulta,
                            p.nome as paciente,
                            p.telefone,
                            p.celular,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            c.nome as convenio,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
//        $this->db->where('e.situacao !=', 'PENDENTE');
//        $this->db->where('ae.confirmado', 't');
        $this->db->where("( (ag.tipo = 'ESPECIALIDADE') OR ( (ae.tipo = 'FISIOTERAPIA' OR ae.tipo = 'ESPECIALIDADE') AND ae.procedimento_tuss_id IS NULL) )");
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->orderby('ae.realizada', 'desc');
        $this->db->orderby('al.situacao');
        $this->db->orderby('ae.data_autorizacao');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
            $this->db->where('ae.data', $dataAtual);
            $this->db->where('ae.medico_consulta_id', $operador_id);
        } else {
            if ($perfil_id == 4) {
                $this->db->where('ae.medico_consulta_id', $operador_id);
            }
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['txtCICPrimario']) && strlen($args['txtCICPrimario']) > 0) {
                $this->db->where('al.cid ilike', "%" . $args['txtCICPrimario'] . "%");
//                $this->db->orwhere('al.cid2 ilike', "%" . $args['txtCICPrimario'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
            if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
                $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                if ($args['situacao'] == "BLOQUEADO") {
                    $this->db->where('ae.bloqueado', 't');
                }
                if ($args['situacao'] == "LIVRE") {
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.situacao', 'LIVRE');
                }
                if ($args['situacao'] == "OK") {
                    $this->db->where('ae.situacao', 'OK');
                }
                if ($args['situacao'] == "FALTOU") {
                    date_default_timezone_set('America/Fortaleza');
                    $data_atual = date('Y-m-d');
                    $this->db->where('ae.data <', $data_atual);
                    $this->db->where('ae.situacao', 'OK');
                    $this->db->where('ae.realizada', 'f');
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.operador_atualizacao is not null');
                }
            }
        }
        return $this->db;
    }

    function listarmultifuncaofisioterapia($args = array()) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
//        $this->db->where('ae.confirmado', 't');
        $this->db->where("( (ag.tipo = 'ESPECIALIDADE') OR ( (ae.tipo = 'FISIOTERAPIA' OR ae.tipo = 'ESPECIALIDADE') AND ae.procedimento_tuss_id IS NULL) )");
//        $this->db->orderby('ae.realizada', 'desc');
//        $this->db->orderby('al.situacao');
//        $this->db->orderby('ae.data_autorizacao');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');

        if ($teste == true) {
            $this->db->where('ae.data', $dataAtual);
            $this->db->where('ae.medico_consulta_id', $operador_id);
        } else {
            if ($perfil_id == 4) {
                $this->db->where('ae.medico_consulta_id', $operador_id);
            }

            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['txtCICPrimario']) && strlen($args['txtCICPrimario']) > 0) {
                $this->db->where('al.cid ilike', "%" . $args['txtCICPrimario'] . "%");
//                $this->db->orwhere('al.cid2 ilike', "%" . $args['txtCICPrimario'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                if ($args['situacao'] == "BLOQUEADO") {
                    $this->db->where('ae.bloqueado', 't');
                }
                if ($args['situacao'] == "LIVRE") {
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.situacao', 'LIVRE');
                }
                if ($args['situacao'] == "OK") {
                    $this->db->where('ae.situacao', 'OK');
                }
                if ($args['situacao'] == "FALTOU") {
                    date_default_timezone_set('America/Fortaleza');
                    $data_atual = date('Y-m-d');
                    $this->db->where('ae.data <', $data_atual);
                    $this->db->where('ae.situacao', 'OK');
                    $this->db->where('ae.realizada', 'f');
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.operador_atualizacao is not null');
                }
            }
        }
        return $this->db;
    }

    function listarmultifuncao2fisioterapia($args = array(), $ordem_chegada) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.data_autorizacao,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.encaixe,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.bloqueado,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            e.situacao as situacaoexame,
                            p.paciente_id,
                            ae.agenda_exames_nome_id,
                            an.nome as sala,
                            o.nome as medicoconsulta,
                            p.nome as paciente,
                            p.telefone,
                            p.celular,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            c.nome as convenio,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
//        $this->db->where('e.situacao !=', 'PENDENTE');
//        $this->db->where('ae.confirmado', 't');
        $this->db->where("( (ag.tipo = 'ESPECIALIDADE') OR ( (ae.tipo = 'FISIOTERAPIA' OR ae.tipo = 'ESPECIALIDADE') AND ae.procedimento_tuss_id IS NULL) )");
        $this->db->orderby('ae.data');
        if ($ordem_chegada == 't') {
            $this->db->orderby('ae.data_autorizacao');
        } else {
            $this->db->orderby('ae.inicio');
        }
//        $this->db->orderby('ae.inicio');
        $this->db->orderby('ae.realizada', 'desc');
        $this->db->orderby('al.situacao');
        $this->db->orderby('ae.data_autorizacao');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
            $this->db->where('ae.data', $dataAtual);
            $this->db->where('ae.medico_consulta_id', $operador_id);
        } else {
            if ($perfil_id == 4) {
                $this->db->where('ae.medico_consulta_id', $operador_id);
            }
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['txtCICPrimario']) && strlen($args['txtCICPrimario']) > 0) {
                $this->db->where('al.cid ilike', "%" . $args['txtCICPrimario'] . "%");
//                $this->db->orwhere('al.cid2 ilike', "%" . $args['txtCICPrimario'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
            if (isset($args['especialidade']) && strlen($args['especialidade']) > 0) {
                $this->db->where('o.cbo_ocupacao_id', $args['especialidade']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                if ($args['situacao'] == "BLOQUEADO") {
                    $this->db->where('ae.bloqueado', 't');
                }
                if ($args['situacao'] == "LIVRE") {
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.situacao', 'LIVRE');
                }
                if ($args['situacao'] == "OK") {
                    $this->db->where('ae.situacao', 'OK');
                }
                if ($args['situacao'] == "FALTOU") {
                    date_default_timezone_set('America/Fortaleza');
                    $data_atual = date('Y-m-d');
                    $this->db->where('ae.data <', $data_atual);
                    $this->db->where('ae.situacao', 'OK');
                    $this->db->where('ae.realizada', 'f');
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.operador_atualizacao is not null');
                }
            }
        }
        return $this->db;
    }

    function listarmultifuncaopsicologia($args = array()) {
        $teste = empty($args);
        $empresa_id = $this->session->userdata('empresa_id');
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            o.nome as medicoconsulta,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.tipo', 'PSICOLOGIA');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
//        if ((!isset($args['nome'])&& $args['nome'] == 0) || (!isset($args['data'])&& strlen($args['data']) == '') || (!isset($args['sala'])&& strlen($args['sala']) == '') || (!isset($args['medico'])&& strlen($args['medico']) =='')) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            } if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarmultifuncao2psicologia($args = array()) {
        $teste = empty($args);
        $operador_id = $this->session->userdata('operador_id');
        $dataAtual = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.data_autorizacao,
                            ae.fim,
                            ae.ativo,
                            ae.telefonema,
                            ae.situacao,
                            ae.guia_id,
                            ae.data_atualizacao,
                            ae.paciente_id,
                            ae.observacoes,
                            ae.realizada,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            an.nome as sala,
                            o.nome as medicoconsulta,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            c.nome as convenio,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.tipo', 'PSICOLOGIA');
        $this->db->orderby('ae.realizada', 'desc');
        $this->db->orderby('al.situacao');
        $this->db->orderby('ae.data_autorizacao');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.inicio');
//        $this->db->where('ae.confirmado', 'true');
//        $this->db->where('ae.ativo', 'false');
//        $this->db->where('ae.realizada', 'false');
        $this->db->where('ae.cancelada', 'false');
        if ($teste == true) {
//        if ((!isset($args['nome'])&& $args['nome'] == 0) || (!isset($args['data'])&& strlen($args['data']) == '') || (!isset($args['sala'])&& strlen($args['sala']) == '') || (!isset($args['medico'])&& strlen($args['medico']) =='')) {
            $this->db->where('ae.medico_consulta_id', $operador_id);
            $this->db->where('ae.data', $dataAtual);
        } else {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
            if (isset($args['data']) && strlen($args['data']) > 0) {
                $this->db->where('ae.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
            }
            if (isset($args['sala']) && strlen($args['sala']) > 0) {
                $this->db->where('ae.agenda_exames_nome_id', $args['sala']);
            }
            if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
                $this->db->where('ae.situacao', $args['situacao']);
            } if (isset($args['medico']) && strlen($args['medico']) > 0) {
                $this->db->where('ae.medico_consulta_id', $args['medico']);
            }
        }
        return $this->db;
    }

    function listarguiafaturamento() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('g.ambulatorio_guia_id,
                            ae.valor_total as valortotal,
                            ae.valor1 as valorfaturado,
                            p.nome as paciente,
                            ae.agenda_exames_id,
                            ae.faturado,
                            ae.numero_sessao,
                            ae.situacao_faturamento,
                            g.data_criacao,
                            ae.autorizacao,
                            c.nome,
                            ae.financeiro,
                            pt.nome as procedimento,
                            pt.codigo,
                            o.nome as medico,
                            ae.paciente_id,
                            ae.tipo,
                            ae.data_faturar,
                            ae.data,
                            observacao_faturamento');
        $this->db->from('tb_ambulatorio_guia g');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id= al.medico_parecer1', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->where("c.dinheiro", 'f');
        $this->db->where("ae.confirmado", 't');
//        $this->db->where("( (ae.tipo != 'CIRURGICO') OR (pt.grupo != 'CIRURGICO') )");
        $this->db->where('pt.grupo !=', 'CIRURGICO');
//        $this->db->where('pt.grupo !=', 'MEDICAMENTO');
        $this->db->where('ae.cancelada', 'f');
        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->orderby('g.ambulatorio_guia_id');
        $this->db->orderby('g.data_criacao');
        $this->db->orderby('p.nome');
        $this->db->orderby('ae.numero_sessao');
        $this->db->orderby('ae.paciente_id');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarguiafaturamentomanualcirurgico() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('g.ambulatorio_guia_id,
                            aee.valor,
                            p.nome as paciente,
                            ae.agenda_exames_id,
                            ae.faturado,
                            ae.numero_sessao,
                            g.data_criacao,
                            g.equipe,
                            ae.autorizacao,
                            c.nome,
                            ae.financeiro,
                            pt.nome as procedimento,
                            pt.codigo,
                            o.nome as medico,
                            ae.paciente_id,
                            g.observacoes');
        $this->db->from('tb_agenda_exame_equipe aee');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = aee.agenda_exames_id');
        $this->db->join('tb_ambulatorio_guia g', 'g.ambulatorio_guia_id = ae.guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id= al.medico_parecer1', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');

        $this->db->where("g.data_criacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("g.data_criacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('ae.cancelada', 'false');

        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }

        $this->db->orderby('g.ambulatorio_guia_id');
        $this->db->orderby('g.data_criacao');
        $this->db->orderby('p.nome');
        $this->db->orderby('ae.numero_sessao');
        $this->db->orderby('ae.paciente_id');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarguiafaturamentomanual() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('g.ambulatorio_guia_id,
                            ae.valor_total as valortotal,
                            ae.valor1 as valorfaturado,
                            p.nome as paciente,
                            ae.agenda_exames_id,
                            ae.faturado,
                            ae.numero_sessao,
                            g.data_criacao,
                            g.equipe,
                            ae.autorizacao,
                            c.nome,
                            ae.financeiro,
                            pt.nome as procedimento,
                            pt.codigo,
                            o.nome as medico,
                            ae.paciente_id,
                            g.observacoes');
        $this->db->from('tb_ambulatorio_guia g');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id= al.medico_parecer1', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("g.data_criacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("g.data_criacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
//        $this->db->where("c.dinheiro", 'f');
//        $this->db->where("ae.confirmado", 't');
//        if ($_POST['tipo'] != '') {
//            if ($_POST['tipo'] == 'CIRURGICO') {
//                $this->db->where('ae.tipo', 'CIRURGICO');
//            } else {
        $this->db->where('ae.tipo !=', 'CIRURGICO');
//            }
//        }

        $this->db->where('ae.cancelada', 'false');
        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
//        if ($_POST['medico'] != "0") {
//            $this->db->where('al.medico_parecer1', $_POST['medico']);
//        }
//        if ($_POST['empresa'] != "0") {
//            $this->db->where('ae.empresa_id', $_POST['empresa']);
//        }
        $this->db->orderby('g.ambulatorio_guia_id');
        $this->db->orderby('g.data_criacao');
        $this->db->orderby('p.nome');
        $this->db->orderby('ae.numero_sessao');
        $this->db->orderby('ae.paciente_id');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listargxmlfaturamento($args = array()) {
        $_POST['datainicio'] = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datainicio'])));
        $_POST['datafim'] = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datafim'])));

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('g.ambulatorio_guia_id,
                            ae.valor_total,
                            ae.valor,
                            ae.autorizacao,
                            p.convenionumero,
                            p.nome as paciente,
                            op.nome as medicosolicitante,
                            op.conselho as conselhosolicitante,
                            o.nome as medico,
                            o.conselho,
                            o.cbo_ocupacao_id,
                            o.cpf,
                            ae.data_autorizacao,
                            ae.data_realizacao,
                            pt.codigo,
                            tu.descricao as procedimento,
                            ae.data,
                            pt.grupo,
                            c.nome as convenio,
                            tuc.nome as classificacao,
                            ae.quantidade,
                            c.registroans,
                            c.codigoidentificador,
                            e.data_cadastro,
                            e.data_atualizacao,
                            g.data_criacao,
                            ae.guiaconvenio,
                            ae.paciente_id');
        $this->db->from('tb_ambulatorio_guia g');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_tuss_classificacao tuc', 'tuc.tuss_classificacao_id = tu.classificacao', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("c.dinheiro", 'f');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.cancelada', 'false');
        if (isset($_POST['datainicio']) && strlen($_POST['datainicio']) > 0) {
            $this->db->where('ae.data >=', $_POST['datainicio']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['tipo'] != "0" && $_POST['tipo'] != "") {
            $this->db->where("tu.classificacao", $_POST['tipo']);
        }
        if ($_POST['tipo'] == "") {
            $this->db->where("tu.classificacao", "2");
            $this->db->where("tu.classificacao", "3");
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
        if (isset($_POST['datafim']) && strlen($_POST['datafim']) > 0) {
            $this->db->where('ae.data <=', $_POST['datafim']);
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarpacientesxmlfaturamento($args = array()) {
        $_POST['datainicio'] = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datainicio'])));
        $_POST['datafim'] = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datafim'])));

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.paciente_id, ae.guiaconvenio, convenionumero, p.nome as paciente, ambulatorio_guia_id');
        $this->db->from('tb_ambulatorio_guia g');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_tuss_classificacao tuc', 'tuc.tuss_classificacao_id = tu.classificacao', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("c.dinheiro", 'f');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');
        if (isset($_POST['datainicio']) && strlen($_POST['datainicio']) > 0) {
            $this->db->where('ae.data >=', $_POST['datainicio']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['tipo'] != "0" && $_POST['tipo'] != "") {
            $this->db->where("tu.classificacao", $_POST['tipo']);
        }
        if ($_POST['tipo'] == "") {
            $this->db->where("tu.classificacao", "2");
            $this->db->where("tu.classificacao", "3");
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
        if (isset($_POST['datafim']) && strlen($_POST['datafim']) > 0) {
            $this->db->where('ae.data <=', $_POST['datafim']);
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->groupby('ae.paciente_id, ae.guiaconvenio, convenionumero, p.nome, ambulatorio_guia_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarxmlfaturamentoexames($args = array()) {
        $_POST['datainicio'] = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datainicio'])));
        $_POST['datafim'] = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['datafim'])));

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select("g.ambulatorio_guia_id,
                            sum(ae.valor_total) as valor_total,
                            ae.valor,
                            ae.autorizacao,
                            op.nome as medicosolicitante,
                            op.conselho as conselhosolicitante,
                            o.nome as medico,
                            o.conselho,
                            o.cbo_ocupacao_id,
                            o.cpf,
                            pt.codigo,
                            pt.grupo,
                            tu.descricao as procedimento,
                            sum(ae.quantidade) as quantidade,
                            ae.guiaconvenio,
                            ae.paciente_id");
        $this->db->from("tb_ambulatorio_guia g");
        $this->db->join("tb_agenda_exames ae", "ae.guia_id = g.ambulatorio_guia_id", "left");
        $this->db->join("tb_paciente p", "p.paciente_id = ae.paciente_id", "left");
        $this->db->join("tb_procedimento_convenio pc", "pc.procedimento_convenio_id = ae.procedimento_tuss_id", "left");
        $this->db->join("tb_procedimento_tuss pt", "pt.procedimento_tuss_id = pc.procedimento_tuss_id", "left");
        $this->db->join("tb_tuss tu", "tu.tuss_id = pt.tuss_id", "left");
        $this->db->join("tb_tuss_classificacao tuc", "tuc.tuss_classificacao_id = tu.classificacao", "left");
        $this->db->join("tb_exame_sala an", "an.exame_sala_id = ae.agenda_exames_nome_id", "left");
        $this->db->join("tb_exames e", "e.agenda_exames_id= ae.agenda_exames_id", "left");
        $this->db->join("tb_ambulatorio_laudo al", "al.exame_id = e.exames_id", "left");
        $this->db->join("tb_operador o", "o.operador_id = al.medico_parecer1", "left");
        $this->db->join("tb_operador op", "op.operador_id = ae.medico_solicitante", "left");
        $this->db->join("tb_convenio c", "c.convenio_id = pc.convenio_id", "left");
        $this->db->where("c.dinheiro", 'f');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.cancelada', 'false');
        if (isset($_POST['datainicio']) && strlen($_POST['datainicio']) > 0) {
            $this->db->where('ae.data >=', $_POST['datainicio']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['tipo'] != "0" && $_POST['tipo'] != "") {
            $this->db->where("tu.classificacao", $_POST['tipo']);
        }
        if ($_POST['tipo'] == "") {
            $this->db->where("tu.classificacao", "2");
            $this->db->where("tu.classificacao", "3");
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
        if (isset($_POST['datafim']) && strlen($_POST['datafim']) > 0) {
            $this->db->where('ae.data <=', $_POST['datafim']);
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->groupby("g.ambulatorio_guia_id,ae.valor, ae.autorizacao,
                            op.nome,
                            op.conselho,
                            o.nome,
                            o.conselho,
                            o.cbo_ocupacao_id,
                            o.cpf,
                            pt.grupo,
                            pt.codigo,
                            tu.descricao,
                            ae.guiaconvenio,
                            ae.paciente_id");
        $return = $this->db->get();
        return $return->result();
    }

    function listarxmldataautorizacao($ambulatorio_guia_id) {
        $this->db->select('data_cadastro');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where('ambulatorio_guia_id', $ambulatorio_guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listargastodesalaguia($exame_id) {
        $this->db->select('guia_id');
        $this->db->from('tb_exames');
        $this->db->where('exames_id', $exame_id);
        $return = $this->db->get();
        $return = $return->result();
        return $return[0]->guia_id;
    }

    function listararmazemsala($sala_id) {
        $this->db->select('armazem_id');
        $this->db->from('tb_exame_sala');
        $this->db->where('exame_sala_id', $sala_id);
        $return = $this->db->get();
        $return = $return->result();
//        var_dump($return); die;
        return $return[0]->armazem_id;
    }

    function listaagendaexames($exame_id) {
        $this->db->select('ae.tipo, ae.medico_agenda, pc.convenio_id, ae.paciente_id, al.ambulatorio_laudo_id');
        $this->db->from('tb_exames e');
        $this->db->join("tb_agenda_exames ae", "ae.agenda_exames_id = e.agenda_exames_id", "left");
        $this->db->join("tb_ambulatorio_laudo al", "al.exame_id = e.exames_id", "left");
        $this->db->join("tb_procedimento_convenio pc", "pc.procedimento_convenio_id = ae.procedimento_tuss_id", "left");
        $this->db->where('e.exames_id', $exame_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaprocedimento($procedimento_id, $convenio_id) {
        $this->db->select('pc.*');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->where('pc.procedimento_tuss_id', $procedimento_id);
        $this->db->where('pc.convenio_id', $convenio_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($procedimento_tuss_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->update('tb_procedimento_tuss');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function procedimentohomecare($agenda_exames_id) {
        $this->db->select('agrupador_fisioterapia, ag.nome,
                            numero_sessao,
                            pt.home_care,
                            qtde_sessao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join("tb_procedimento_convenio pc", "pc.procedimento_convenio_id = ae.procedimento_tuss_id", "left");
        $this->db->join("tb_procedimento_tuss pt", "pt.procedimento_tuss_id = pc.procedimento_tuss_id", "left");
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $query = $this->db->get();
        $retorno = $query->result();

        return $home_care = $retorno[0]->home_care;
    }

    function verificadiasessao($agenda_exames_id) {

        $this->db->select('agrupador_fisioterapia, ag.nome, ae.data,
                            numero_sessao,
                            qtde_sessao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join("tb_procedimento_convenio pc", "pc.procedimento_convenio_id = ae.procedimento_tuss_id", "left");
        $this->db->join("tb_procedimento_tuss pt", "pt.procedimento_tuss_id = pc.procedimento_tuss_id", "left");
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $query = $this->db->get();
        $retorno = $query->result();

        return $retorno;
    }

    function verificadiasessaohomecare($agenda_exames_id) {

        $this->db->select(' agrupador_fisioterapia, 
                            ag.nome,
                            numero_sessao,
                            pt.home_care,
                            qtde_sessao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join("tb_procedimento_convenio pc", "pc.procedimento_convenio_id = ae.procedimento_tuss_id", "left");
        $this->db->join("tb_procedimento_tuss pt", "pt.procedimento_tuss_id = pc.procedimento_tuss_id", "left");
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $query = $this->db->get();
        $retorno = $query->result();

        $home_care = $retorno[0]->home_care;
        $sessao = $retorno[0]->numero_sessao;
        $agrupador = $retorno[0]->agrupador_fisioterapia;
        $qtde_sessao = $retorno[0]->qtde_sessao;
        $grupo = $retorno[0]->nome;

        $i = 1;
        $x = 0;

//        echo "<pre>";
//        var_dump($home_care, $sessao, $agrupador, $qtde_sessao, $grupo);
//        die;

        while ($i < $qtde_sessao) {

            $data = date("Y-m-d");
            $this->db->select('ae.data, ag.nome');
            $this->db->from('tb_agenda_exames ae');
            $this->db->join("tb_procedimento_convenio pc", "pc.procedimento_convenio_id = ae.procedimento_tuss_id", "left");
            $this->db->join("tb_convenio c", "pc.convenio_id = c.convenio_id", "left");
            $this->db->join("tb_procedimento_tuss pt", "pt.procedimento_tuss_id = pc.procedimento_tuss_id", "left");
            $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
            $this->db->where('agrupador_fisioterapia', $agrupador);
            $this->db->where('numero_sessao', $i);
            $this->db->where('c.dinheiro', 'false');
            $this->db->where('ae.confirmado', 't');
            $this->db->where('ag.nome', $grupo);
            $this->db->where('data', $data);
            $query2 = $this->db->get();
            $retorno2 = $query2->result();

            if (count($retorno2) != 0) {
//                echo "<pre>";
//                var_dump($i, $grupo, $data, $qtde_sessao, $agrupador);
//                var_dump($retorno2); die;
                $x++;
            }
            $i++;
        }

//        die;
        return $x;
    }

    function autorizarsessao($agenda_exames_id) {

        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $hora = date("H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('confirmado', 't');
        $this->db->set('ordenador', '1');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('data', $data);
        $this->db->set('inicio', $hora);
        $this->db->set('fim', $hora);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('data_autorizacao', $horario);
        $this->db->set('operador_autorizacao', $operador_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
    }

    function gravarnome($nome) {
        try {
            $this->db->set('nome', $nome);
            $this->db->insert('tb_agenda_exames_nome');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $agenda_exames_nome_id = $this->db->insert_id();
            return $agenda_exames_nome_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravargastodesala() {
        $horario = date('Y-m-d');
        $operador_id = $this->session->userdata('operador_id');


// ESTOQUE SAIDA E SALDO
        //   SELECIONA

        $this->db->select('estoque_entrada_id,
                            produto_id,
                            fornecedor_id,
                            armazem_id,
                            valor_compra,
                            quantidade,
                            nota_fiscal,
                            validade');
        $this->db->from('tb_estoque_entrada e');
        $this->db->where('produto_id', $_POST['produto_id']);
        $this->db->where('armazem_id', $_POST['armazem_id']);
        $this->db->where('ativo', 't');
        $this->db->where('quantidade >', '0');
        $this->db->orderby("validade");
//        echo '<pre>';

        $return = $this->db->get()->result();



        if ($_POST['descricao'] != '') {
            $this->db->set('descricao', $_POST['descricao']);
        }
        $this->db->set('guia_id', $_POST['txtguia_id']);
        $this->db->set('produto_id', $_POST['produto_id']);
        $this->db->set('quantidade', $_POST['txtqtde']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_gasto_sala');
        $ambulatorio_gasto_sala_id = $this->db->insert_id();



        //GRAVA     
        // SAIDA 


        $this->db->set('estoque_entrada_id', $return[0]->estoque_entrada_id);
//        $this->db->set('solicitacao_cliente_id', $_POST['txtestoque_solicitacao_id']);
        if ($_POST['txtexame'] != '') {
            $this->db->set('exames_id', $_POST['txtexame']);
        }
        $this->db->set('produto_id', $return[0]->produto_id);
        $this->db->set('fornecedor_id', $return[0]->fornecedor_id);
        $this->db->set('armazem_id', $return[0]->armazem_id);
        $this->db->set('valor_venda', $return[0]->valor_compra);
        $this->db->set('ambulatorio_gasto_sala_id', $ambulatorio_gasto_sala_id);
        $this->db->set('quantidade', str_replace(",", ".", str_replace(".", "", $_POST['txtqtde'])));
        $this->db->set('nota_fiscal', $return[0]->nota_fiscal);
        if ($return[0]->validade != "") {
            $this->db->set('validade', $return[0]->validade);
        }
//        $horario = date("Y-m-d H:i:s");
//        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_estoque_saida');
        $estoque_saida_id = $this->db->insert_id();

        // SALDO 
        $this->db->set('estoque_entrada_id', $return[0]->estoque_entrada_id);
        $this->db->set('estoque_saida_id', $estoque_saida_id);
        $this->db->set('produto_id', $return[0]->produto_id);
        $this->db->set('fornecedor_id', $return[0]->fornecedor_id);
        $this->db->set('armazem_id', $return[0]->armazem_id);
        $this->db->set('valor_compra', $return[0]->valor_compra);
        $this->db->set('ambulatorio_gasto_sala_id', $ambulatorio_gasto_sala_id);
        $quantidade = -(str_replace(",", ".", str_replace(".", "", $_POST['txtqtde'])));
        $this->db->set('quantidade', $quantidade);
        $this->db->set('nota_fiscal', $return[0]->nota_fiscal);
        if ($return[0]->validade != "") {
            $this->db->set('validade', $return[0]->validade);
        }
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_estoque_saldo');
    }

    function excluirgastodesala($gasto_id) {
        $horario = date('Y-m-d');
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'false');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_gasto_sala_id', $gasto_id);
        $this->db->update('tb_ambulatorio_gasto_sala');



        $this->db->set('ativo', 'f');
        $this->db->where('ambulatorio_gasto_sala_id', $gasto_id);
        $this->db->update('tb_estoque_saida');

        $this->db->set('ativo', 'f');
        $this->db->where('ambulatorio_gasto_sala_id', $gasto_id);
        $this->db->update('tb_estoque_saldo');
    }

    function faturargastodesala($dados) {
        $horario = date('Y-m-d');
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $hora = date("H:i:s");
        $data = date("Y-m-d");
        $valortotal = (int) $_POST['txtqtde'] * (float) $dados->valortotal;

        $this->db->set('procedimento_tuss_id', $dados->procedimento_convenio_id);
        $this->db->set('valor', $dados->valortotal);
        $this->db->set('valor1', $dados->valortotal);
        $this->db->set('valor_total', $valortotal);
        $this->db->set('quantidade', $_POST['txtqtde']);
//            $this->db->set('autorizacao', $_POST['autorizacao1']);
        $this->db->set('empresa_id', $empresa_id);
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
//            $this->db->set('data', $_POST['txtdata']);
        $this->db->set('data_autorizacao', $horario);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('data', $data);
        $this->db->set('data_faturar', $data);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set('data_realizacao', $horario);
        $this->db->set('operador_realizacao', $operador_id);
        $this->db->set('data_faturamento', $horario);
        $this->db->set('operador_faturamento', $operador_id);
        $this->db->set('operador_autorizacao', $operador_id);
        $this->db->insert('tb_agenda_exames');
        $agenda_exames_id = $this->db->insert_id();


        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('procedimento_tuss_id', $dados->procedimento_convenio_id);
        $this->db->set('paciente_id', $_POST['txtpaciente_id']);
        $this->db->set('medico_realizador', $_POST['medicoagenda']);
        $this->db->set('situacao', 'FINALIZADO');
        $this->db->set('guia_id', $_POST['txtguia_id']);
        $this->db->set('agenda_exames_id', $agenda_exames_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_exames');
        $exames_id = $this->db->insert_id();
    }

    function contadorexames() {


        $this->db->select('agenda_exames_id');
        $this->db->from('tb_exames');
        $this->db->where('situacao !=', 'CANCELADO');
        $this->db->where("agenda_exames_id", $_POST['txtagenda_exames_id']);
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadorexamestodos() {

        $this->db->select('pt.grupo');
        $this->db->from('tb_exames e');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->where('e.situacao !=', 'CANCELADO');
        $this->db->where("e.guia_id", $_POST['txtguia_id']);
        $this->db->where("pt.grupo", $_POST['txtgrupo']);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarexamesguias($guia_id) {

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
                            ae.entregue,
                            ae.data_entregue,
                            p.nome as paciente,
                            p.indicacao,
                            p.nascimento,
                            ae.entregue_telefone,
                            o.nome as operadorrecebido,
                            op.nome as operadorentregue,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id= pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_recebido', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_entregue', 'left');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.guia_id', $guia_id);
        $this->db->orderby('ae.guia_id');
        $this->db->orderby('ae.agenda_exames_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarguia($agenda_exames_id) {

        $this->db->select('ag.ambulatorio_guia_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            p.nome as paciente,
                            c.nome as convenio,
                            p.nascimento,
                            ae.data_cadastro as datacadastro,
                            ag.peso,
                            ag.altura,
                            ag.pasistolica,
                            ag.padiastolica,
                            o.usuario as medico,
                            op.usuario as operadorcadastro');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = ag.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_cadastro', 'left');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendaauditoria($agenda_exames_id) {

        $this->db->select('ae.paciente_id,
                            p.nome as paciente,
                            p.nascimento,
                            ae.data_cadastro as datacadastro,
                            op.nome as operadorcadastro');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_cadastro', 'left');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendadoauditoria($agenda_exames_id) {

        $this->db->select('ae.paciente_id,
                            p.nome as paciente,
                            c.nome as convenio,
                            p.nascimento,
                            ae.data_cadastro as datacadastro,
                            ae.data_autorizacao,
                            ae.data_atualizacao,
                            o.usuario as medico,
                            op.nome as operadorcadastro,
                            ope.nome as operadoratualizacao,
                            opa.nome as operadorautorizacao,
                            opai.nome as operador_bloqueio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_cadastro', 'left');
        $this->db->join('tb_operador opa', 'opa.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador ope', 'ope.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador opai', 'opai.operador_id = ae.operador_bloqueio', 'left');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listardadosagendacriada() {

        $this->db->select('ae.data_fim,
                           ae.data_inicio,
                           ae.tipo,
                           tipo_consulta_id,
                           agenda_exames_nome_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where("ae.horarioagenda_id", $_GET['agenda_id']);
        $this->db->where("ae.medico_agenda", $_GET['medico_id']);
        $this->db->where("ae.nome", $_GET['nome_agenda']);
        $this->db->where("((tipo = 'EXAME' AND ae.paciente_id IS NULL) OR (tipo != 'EXAME'))");
        $this->db->limit(1);
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioagendadoauditoria($agenda_exames_id) {

        $this->db->select('ae.paciente_id,
                            p.nome as paciente,
                            c.nome as convenio,
                            p.nascimento,
                            ae.data_cadastro as datacadastro,
                            ae.data_autorizacao,
                            ae.data_atualizacao,
                            o.usuario as medico,
                            op.nome as operadorcadastro,
                            ope.nome as operadoratualizacao,
                            opa.nome as operadorautorizacao,
                            opai.nome as operador_bloqueio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_cadastro', 'left');
        $this->db->join('tb_operador opa', 'opa.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador ope', 'ope.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador opai', 'opai.operador_id = ae.operador_bloqueio', 'left');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendamedicocurriculo($medico_agenda) {

        $this->db->select('o.operador_id,
                            o.curriculo,
                            o.nome as medico
                            ');
        $this->db->from('tb_operador o');
        $this->db->where("o.operador_id", $medico_agenda);
        $return = $this->db->get();
        return $return->result();
    }

    function listaratendimentos($guia_id) {

        $this->db->select('ag.ambulatorio_guia_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            p.nome as paciente,
                            c.nome as convenio,
                            p.nascimento,
                            ag.peso,
                            ag.altura,
                            ag.pasistolica,
                            ag.padiastolica,
                            o.usuario as medico');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = ag.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarexamepreparo($agenda_exames_id) {
        $this->db->set('sala_preparo', 'f');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
    }

    function gravarsalapreparo() {
        $this->db->set('sala_preparo', 't');
        $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
        $this->db->update('tb_agenda_exames');
    }

    function gravarexame($percentual) {
        try {
            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $exame_id = $_POST['txtagenda_exames_id'];
//            echo '<pre>';
//            var_dump($_POST['txtpaciente_id']);
//            var_dump($_POST['txtprocedimento_tuss_id']);
//            var_dump($_POST['txtguia_id']);
//            var_dump($_POST['txtagenda_exames_id']);
//            var_dump($_POST['txttipo']);
//            die;

            if ($_POST['txttipo'] == 'EXAME' || $_POST['txttipo'] == 'MEDICAMENTO' || $_POST['txttipo'] == 'MATERIAL') {

//                $this->db->set('ativo', 'f');
//                $this->db->where('exame_sala_id', $_POST['txtsalas']);
//                $this->db->update('tb_exame_sala');

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);

                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $agenda_exames_id = $_POST['txtguia_id'];
                $this->db->set('sala_id', $_POST['txtsalas']);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_realizador', $_POST['txtmedico']);
                }
                if ($_POST['txttecnico'] != "") {
                    $this->db->set('tecnico_realizador', $_POST['txttecnico']);
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exames');
                $exames_id = $this->db->insert_id();

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data', $data);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('exame_id', $exames_id);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_parecer1', $_POST['txtmedico']);
                }
                $this->db->insert('tb_ambulatorio_laudo');
                $laudo_id = $this->db->insert_id();
                $guia_id = $_POST['txtguia_id'];

                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['txtmedico']);
                    $this->db->set('medico_agenda', $_POST['txtmedico']);
                    $this->db->set('valor_medico', $percentual[0]->perc_medico);
                    $this->db->set('percentual_medico', $percentual[0]->percentual);
                }
                $this->db->set('realizada', 'true');
                $this->db->set('senha', md5($exame_id));
                $this->db->set('data_realizacao', $horario);
                $this->db->set('operador_realizacao', $operador_id);
                $this->db->set('agenda_exames_nome_id', $_POST['txtsalas']);
                $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->update('tb_agenda_exames');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->set('sala_id', $_POST['txtsalas']);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->insert('tb_ambulatorio_chamada');
            }

            if ($_POST['txttipo'] == 'CONSULTA') {

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $agenda_exames_id = $_POST['txtguia_id'];
                $this->db->set('sala_id', $_POST['txtsalas']);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_realizador', $_POST['txtmedico']);
                }
                if ($_POST['txttecnico'] != "") {
                    $this->db->set('tecnico_realizador', $_POST['txttecnico']);
                }
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exames');
                $exames_id = $this->db->insert_id();

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data', $data);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('exame_id', $exames_id);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_parecer1', $_POST['txtmedico']);
                }
                $this->db->insert('tb_ambulatorio_laudo');
                $laudo_id = $this->db->insert_id();
                $guia_id = $_POST['txtguia_id'];

                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['txtmedico']);
                    $this->db->set('medico_agenda', $_POST['txtmedico']);
                    $this->db->set('valor_medico', $percentual[0]->perc_medico);
                    $this->db->set('percentual_medico', $percentual[0]->percentual);
                }
                $this->db->set('realizada', 'true');
                $this->db->set('senha', md5($exame_id));
                $this->db->set('data_realizacao', $horario);
                $this->db->set('operador_realizacao', $operador_id);
                $this->db->set('agenda_exames_nome_id', $_POST['txtsalas']);
                $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->update('tb_agenda_exames');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->set('sala_id', $_POST['txtsalas']);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->insert('tb_ambulatorio_chamada');
            }

            if ($_POST['txttipo'] == 'ESPECIALIDADE' || $_POST['txttipo'] == 'FISIOTERAPIA') {

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);

                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $agenda_exames_id = $_POST['txtguia_id'];
                $this->db->set('sala_id', $_POST['txtsalas']);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_realizador', $_POST['txtmedico']);
                }
                if ($_POST['txttecnico'] != "") {
                    $this->db->set('tecnico_realizador', $_POST['txttecnico']);
                }
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exames');
                $exames_id = $this->db->insert_id();

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data', $data);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('exame_id', $exames_id);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_parecer1', $_POST['txtmedico']);
                }
                $this->db->insert('tb_ambulatorio_laudo');
                $laudo_id = $this->db->insert_id();
                $guia_id = $_POST['txtguia_id'];

                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['txtmedico']);
                    $this->db->set('medico_agenda', $_POST['txtmedico']);
                    $this->db->set('valor_medico', $percentual[0]->perc_medico);
                    $this->db->set('percentual_medico', $percentual[0]->percentual);
                }
                $this->db->set('realizada', 'true');
                $this->db->set('senha', md5($exame_id));
                $this->db->set('data_realizacao', $horario);
                $this->db->set('operador_realizacao', $operador_id);
                $this->db->set('agenda_exames_nome_id', $_POST['txtsalas']);
                $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->update('tb_agenda_exames');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->set('sala_id', $_POST['txtsalas']);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->insert('tb_ambulatorio_chamada');
            }

            if ($_POST['txttipo'] == 'PSICOLOGIA') {

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $agenda_exames_id = $_POST['txtguia_id'];
                $this->db->set('sala_id', $_POST['txtsalas']);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_realizador', $_POST['txtmedico']);
                }
                if ($_POST['txttecnico'] != "") {
                    $this->db->set('tecnico_realizador', $_POST['txttecnico']);
                }
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exames');
                $exames_id = $this->db->insert_id();

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data', $data);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
                $this->db->set('exame_id', $exames_id);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('tipo', $_POST['txttipo']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_parecer1', $_POST['txtmedico']);
                }
                $this->db->insert('tb_ambulatorio_laudo');
                $laudo_id = $this->db->insert_id();
                $guia_id = $_POST['txtguia_id'];

                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['txtmedico']);
                    $this->db->set('medico_agenda', $_POST['txtmedico']);
                    $this->db->set('valor_medico', $percentual[0]->perc_medico);
                    $this->db->set('percentual_medico', $percentual[0]->percentual);
                }
                $this->db->set('realizada', 'true');
                $this->db->set('senha', md5($exame_id));
                $this->db->set('data_realizacao', $horario);
                $this->db->set('operador_realizacao', $operador_id);
                $this->db->set('agenda_exames_nome_id', $_POST['txtsalas']);
                $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->update('tb_agenda_exames');

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
                $this->db->set('sala_id', $_POST['txtsalas']);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->insert('tb_ambulatorio_chamada');
            }

            return $laudo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarexametodos() {
        try {

            $empresa_id = $this->session->userdata('empresa_id');
            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'f');
            $this->db->where('exame_sala_id', $_POST['txtsalas']);
            $this->db->update('tb_exame_sala');

            $this->db->select('e.procedimento_tuss_id,
                                e.agenda_exames_id');
            $this->db->from('tb_agenda_exames e');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
            $this->db->where('e.situacao !=', 'CANCELADO');
            $this->db->where("e.guia_id", $_POST['txtguia_id']);
            $this->db->where("pt.grupo", $_POST['txtgrupo']);
            $query = $this->db->get();
            $return = $query->result();
            $this->db->trans_start();
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
            $this->db->set('sala_id', $_POST['txtsalas']);
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->insert('tb_ambulatorio_chamada');

            foreach ($return as $value) {
                $procedimento = $value->procedimento_tuss_id;
                $agenda_exames_id = $value->agenda_exames_id;


                $this->db->set('realizada', 'true');
                $this->db->set('data_realizacao', $horario);
                $this->db->set('operador_realizacao', $operador_id);
                $this->db->set('agenda_exames_nome_id', $_POST['txtsalas']);
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $procedimento);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('agenda_exames_id', $agenda_exames_id);
                $this->db->set('sala_id', $_POST['txtsalas']);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_realizador', $_POST['txtmedico']);
                }
                if ($_POST['txttecnico'] != "") {
                    $this->db->set('tecnico_realizador', $_POST['txttecnico']);
                }
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_exames');
                $exames_id = $this->db->insert_id();

                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data', $data);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('procedimento_tuss_id', $procedimento);
                $this->db->set('exame_id', $exames_id);
                $this->db->set('guia_id', $_POST['txtguia_id']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                if ($_POST['txtmedico'] != "") {
                    $this->db->set('medico_parecer1', $_POST['txtmedico']);
                }
                $this->db->insert('tb_ambulatorio_laudo');
                $laudo_id[] = $this->db->insert_id();
            }
            $guia_id = $_POST['txtguia_id'];
            $this->db->trans_complete();

            return $laudo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function telefonema($agenda_exame_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('telefonema', 't');
            $this->db->set('data_telefonema', $horario);
            $this->db->set('operador_telefonema', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function chegada($agenda_exame_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('chegada', 't');
            $this->db->set('data_chegada', $horario);
            $this->db->set('operador_chegada', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function atendimentohora($agenda_exame_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('atendimento', 't');
            $this->db->set('data_atendimento', $horario);
            $this->db->set('operador_atendimento', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function observacao($agenda_exame_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('observacoes', utf8_encode($_POST['txtobservacao']));
            $this->db->set('data_observacoes', $horario);
            $this->db->set('operador_observacoes', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function observacaofaturamentomanual($guia_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('observacoes', $_POST['txtobservacao']);
            $this->db->set('data_observacoes', $horario);
            $this->db->set('operador_observacoes', $operador_id);
            $this->db->where('ambulatorio_guia_id', $guia_id);
            $this->db->update('tb_ambulatorio_guia');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function observacaofaturamento($agenda_exame_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('observacao_faturamento', $_POST['txtobservacao']);
            $this->db->set('data_obs_faturamento', $horario);
            $this->db->set('operador_obs_faturamento', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function cancelarespera() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', null);
            $this->db->set('procedimento_tuss_id', null);
            $this->db->set('guia_id', null);
            $this->db->set('situacao', "LIVRE");
            $this->db->set('observacoes', "");
            $this->db->set('valor', NULL);
            $this->db->set('ativo', 't');
            $this->db->set('convenio_id', null);
            $this->db->set('autorizacao', null);
            $this->db->set('operador_atualizacao', null);
            $this->db->set('confirmado', 'f');
            $this->db->set('data_cancelamento', $horario);
            $this->db->set('operador_cancelamento', $operador_id);
            $this->db->set('cancelada', 't');
            $this->db->set('situacao', 'CANCELADO');
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
            $this->db->update('tb_agenda_exames');


            $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_atendimentos_cancelamento');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function cancelaresperamatmed() {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', null);
            $this->db->set('procedimento_tuss_id', null);
            $this->db->set('guia_id', null);
            $this->db->set('situacao', "LIVRE");
            $this->db->set('observacoes', "");
            $this->db->set('valor', NULL);
            $this->db->set('ativo', 't');
            $this->db->set('convenio_id', null);
            $this->db->set('autorizacao', null);
            $this->db->set('operador_atualizacao', null);
            $this->db->set('confirmado', 'f');
            $this->db->set('data_cancelamento', $horario);
            $this->db->set('operador_cancelamento', $operador_id);
            $this->db->set('cancelada', 't');
            $this->db->set('situacao', 'CANCELADO');
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
            $this->db->update('tb_agenda_exames');


            $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_atendimentos_cancelamento');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function cancelartodosfisioterapia($agenda_exames_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', null);
            $this->db->set('procedimento_tuss_id', null);
            $this->db->set('guia_id', null);
            $this->db->set('situacao', "LIVRE");
            $this->db->set('observacoes', "");
            $this->db->set('valor', NULL);
            $this->db->set('ativo', 't');
            $this->db->set('convenio_id', null);
            $this->db->set('autorizacao', null);
            $this->db->set('operador_atualizacao', null);
            $this->db->set('confirmado', 'f');
            $this->db->set('data_cancelamento', $horario);
            $this->db->set('operador_cancelamento', $operador_id);
            $this->db->set('cancelada', 't');
            $this->db->set('situacao', 'CANCELADO');
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function cancelartodospsicologia($agenda_exames_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', null);
            $this->db->set('procedimento_tuss_id', null);
            $this->db->set('guia_id', null);
            $this->db->set('situacao', "LIVRE");
            $this->db->set('observacoes', "");
            $this->db->set('valor', NULL);
            $this->db->set('ativo', 't');
            $this->db->set('convenio_id', null);
            $this->db->set('autorizacao', null);
            $this->db->set('data_cancelamento', $horario);
            $this->db->set('operador_cancelamento', $operador_id);
            $this->db->set('cancelada', 't');
            $this->db->set('situacao', 'CANCELADO');
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function bloquear($agenda_exame_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', null);
            $this->db->set('procedimento_tuss_id', null);
            $this->db->set('guia_id', null);
            $this->db->set('situacao', "OK");
            $this->db->set('observacoes', "");
            $this->db->set('valor', NULL);
            $this->db->set('ativo', 'f');
            $this->db->set('bloqueado', 't');
            $this->db->set('convenio_id', null);
            $this->db->set('autorizacao', null);
            $this->db->set('data_bloqueio', $horario);
            $this->db->set('operador_bloqueio', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function desbloquear($agenda_exame_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', null);
            $this->db->set('procedimento_tuss_id', null);
            $this->db->set('guia_id', null);
            $this->db->set('situacao', "LIVRE");
            $this->db->set('observacoes', "");
            $this->db->set('valor', NULL);
            $this->db->set('ativo', 't');
            $this->db->set('bloqueado', 'f');
            $this->db->set('convenio_id', null);
            $this->db->set('autorizacao', null);
            $this->db->set('data_desbloqueio', $horario);
            $this->db->set('operador_desbloqueio', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exame_id);
            $this->db->update('tb_agenda_exames');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function cancelarexame() {
        try {

            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $_POST['txtsala_id']);
            $this->db->update('tb_exame_sala');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', null);
            $this->db->set('procedimento_tuss_id', null);
            $this->db->set('guia_id', null);
            $this->db->set('situacao', "LIVRE");
            $this->db->set('observacoes', "");
            $this->db->set('valor', NULL);
            $this->db->set('ativo', 't');
            $this->db->set('convenio_id', null);
            $this->db->set('autorizacao', null);
            $this->db->set('operador_atualizacao', null);
            $this->db->set('confirmado', 'f');
            $this->db->set('data_cancelamento', $horario);
            $this->db->set('operador_cancelamento', $operador_id);
            $this->db->set('cancelada', 't');
            $this->db->set('situacao', 'CANCELADO');
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $this->db->where('agenda_exames_id', $_POST['txtagenda_exames_id']);
            $this->db->update('tb_agenda_exames');

            $this->db->set('data_cancelamento', $horario);
            $this->db->set('operador_cancelamento', $operador_id);
            $this->db->set('cancelada', 't');
            $this->db->set('situacao', 'CANCELADO');
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $this->db->where('exames_id', $_POST['txtexames_id']);
            $this->db->update('tb_exames');

            $this->db->set('data_cancelamento', $horario);
            $this->db->set('operador_cancelamento', $operador_id);
            $this->db->set('cancelada', 't');
            $this->db->set('situacao', 'CANCELADO');
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $this->db->where('exame_id', $_POST['txtexames_id']);
            $this->db->update('tb_ambulatorio_laudo');

            $this->db->set('agenda_exames_id', $_POST['txtagenda_exames_id']);
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('procedimento_tuss_id', $_POST['txtprocedimento_tuss_id']);
            $this->db->set('ambulatorio_cancelamento_id', $_POST['txtmotivo']);
            $this->db->set('observacao_cancelamento', $_POST['observacaocancelamento']);
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_atendimentos_cancelamento');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function voltarexame($exame_id, $sala_id, $agenda_exames_id) {
        try {

            $data = date("Y-m-d");

            $this->db->set('realizada', 'f');
            $this->db->set('sala_pendente', 't');
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');

            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $sala_id);
            $this->db->update('tb_exame_sala');

            $this->db->where('exames_id', $exame_id);
            $this->db->delete('tb_exames');


            $this->db->where('exame_id', $exame_id);
            $this->db->delete('tb_ambulatorio_laudo');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function finalizarexamependente($exame_id, $sala_id, $agenda_exames_id) {
        try {
            // Voltando exame
            $this->db->set('realizada', 'f');
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');

            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $sala_id);
            $this->db->update('tb_exame_sala');

            $this->db->where('exames_id', $exame_id);
            $this->db->delete('tb_exames');

            $this->db->where('exame_id', $exame_id);
            $this->db->delete('tb_ambulatorio_laudo');

            // Enviando da sala de espera
            $this->db->select('ae.agenda_exames_nome_id, 
                               ae.paciente_id, 
                               ae.medico_agenda, 
                               ae.guia_id, 
                               ae.procedimento_tuss_id, 
                               e.medico_realizador,  
                               e.sala_id,  
                               ag.tipo');
            $this->db->from('tb_agenda_exames ae');
            $this->db->join('tb_exames e', 'e.exames_id = ae.agenda_exames_id', 'left');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
            $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
            $retorno = $this->db->get()->result();

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('paciente_id', $retorno[0]->paciente_id);
            $this->db->set('procedimento_tuss_id', $retorno[0]->procedimento_tuss_id);
            $this->db->set('guia_id', $retorno[0]->guia_id);
            $this->db->set('tipo', $retorno[0]->tipo);
            $this->db->set('agenda_exames_id', $agenda_exames_id);
            $this->db->set('sala_id', $retorno[0]->sala_id);
            if ($retorno[0]->medico_realizador != "") {
                $this->db->set('medico_realizador', $retorno[0]->medico_realizador);
            }
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_exames');
            $exames_id = $this->db->insert_id();

            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data', $data);
            $this->db->set('paciente_id', $retorno[0]->paciente_id);
            $this->db->set('procedimento_tuss_id', $retorno[0]->procedimento_tuss_id);
            $this->db->set('exame_id', $exames_id);
            $this->db->set('guia_id', $retorno[0]->guia_id);
            $this->db->set('tipo', $retorno[0]->tipo);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            if ($retorno[0]->medico_realizador != "") {
                $this->db->set('medico_parecer1', $retorno[0]->medico_realizador);
            }
            $this->db->insert('tb_ambulatorio_laudo');
            $laudo_id = $this->db->insert_id();
            $guia_id = $retorno[0]->guia_id;

            if ($retorno[0]->medico_realizador != "") {
                $this->db->set('medico_consulta_id', $retorno[0]->medico_realizador);
                $this->db->set('medico_agenda', $retorno[0]->medico_realizador);

//                $this->db->set('valor_medico', $percentual[0]->perc_medico);
//                $this->db->set('percentual_medico', $percentual[0]->percentual);
            }
            $this->db->set('realizada', 'true');
            $this->db->set('senha', md5($agenda_exames_id));
            $this->db->set('data_realizacao', $horario);
            $this->db->set('operador_realizacao', $operador_id);
            $this->db->set('agenda_exames_nome_id', $retorno[0]->agenda_exames_nome_id);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('agenda_exames_id', $agenda_exames_id);
            $this->db->set('sala_id', $retorno[0]->sala_id);
            $this->db->set('paciente_id', $retorno[0]->paciente_id);
            $this->db->insert('tb_ambulatorio_chamada');

            // Finalizando exame
            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $retorno[0]->sala_id);
            $this->db->update('tb_exame_sala');

            $this->db->set('situacao', 'FINALIZADO');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('exames_id', $exames_id);
            $this->db->update('tb_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function finalizarexame($exames_id, $sala_id) {
        try {

            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $sala_id);
            $this->db->update('tb_exame_sala');

            $this->db->set('situacao', 'FINALIZADO');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('exames_id', $exames_id);
            $this->db->update('tb_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function finalizarexametodos($sala_id, $guia_id, $grupo) {
        try {

            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $sala_id);
            $this->db->update('tb_exame_sala');


            $this->db->select('e.agenda_exames_id');
            $this->db->from('tb_agenda_exames e');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = e.procedimento_tuss_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->where('e.situacao !=', 'CANCELADO');
            $this->db->where("e.guia_id", $guia_id);
            $this->db->where("pt.grupo", $grupo);
            $query = $this->db->get();
            $return = $query->result();

            foreach ($return as $value) {
//                $teste = $teste . "-" . $value->agenda_exames_id;
                $this->db->set('situacao', 'FINALIZADO');
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                $this->db->update('tb_exames');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    return 0;
            }
//            var_dump($teste);
//            die;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function atenderpacienteconsulta($exames_id) {
        try {

            $this->db->set('situacao', 'FINALIZADO');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('exames_id', $exames_id);
            $this->db->update('tb_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function pendenteexamemultifuncao($exames_id) {
        try {
            $this->db->select('e.sala_id');
            $this->db->from('tb_exames e');
            $this->db->where("exames_id", $exames_id);
            $query = $this->db->get();
            $return = $query->result();

            if (@$return[0]->sala_id != '') {
                $this->db->set('ativo', 't');
                $this->db->where('exame_sala_id', $return[0]->sala_id);
                $this->db->update('tb_exame_sala');
            }

            $this->db->set('situacao', 'PENDENTE');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_pendente', $horario);
            $this->db->set('operador_pendente', $operador_id);
            $this->db->where('exames_id', $exames_id);
            $this->db->update('tb_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function pendenteespecialidade($exames_id) {
        try {
            $this->db->select('e.sala_id');
            $this->db->from('tb_exames e');
            $this->db->where("exames_id", $exames_id);
            $query = $this->db->get();
            $return = $query->result();

            if (@$return[0]->sala_id != '') {
                $this->db->set('ativo', 't');
                $this->db->where('exame_sala_id', $return[0]->sala_id);
                $this->db->update('tb_exame_sala');
            }

            $this->db->set('situacao', 'PENDENTE');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_pendente', $horario);
            $this->db->set('operador_pendente', $operador_id);
            $this->db->where('exames_id', $exames_id);
            $this->db->update('tb_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function pendenteexame($exames_id, $sala_id) {
        try {

            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $sala_id);
            $this->db->update('tb_exame_sala');

            $this->db->set('situacao', 'PENDENTE');
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_pendente', $horario);
            $this->db->set('operador_pendente', $operador_id);
            $this->db->where('exames_id', $exames_id);
            $this->db->update('tb_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpaciente($agenda_exames_id) {
        try {
            $OK = 'OK';
            $this->db->set('paciente_id', $_POST['txtpacienteid']);
            $this->db->set('procedimento_tuss_id', $_POST['txprocedimento']);
            $this->db->set('situacao', $OK);
            $this->db->set('ativo', 'false');
            if (isset($_POST['txtConfirmado'])) {
                $this->db->set('confirmado', 't');
            }
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'EXAME');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravar($horarioagenda_id, $agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $sala_id, $id, $medico_id, $empresa_id, $obs = null) {
        try {

            $index = date("Y-m-d", strtotime(str_replace("/", "-", $index)));

            /* inicia o mapeamento no banco */
            $this->db->set('horarioagenda_id', $agenda_id);
            $this->db->set('horario_id', $horarioagenda_id);
            $this->db->set('inicio', $horaconsulta);
            $this->db->set('fim', $horaverifica);
            $this->db->set('nome', $nome);
            $this->db->set('data_inicio', $datainicial);
            $this->db->set('data_fim', $datafinal);
            $this->db->set('data', $index);
            $this->db->set('nome_id', $id);
            if ($medico_id != '') {
                $this->db->set('medico_consulta_id', $medico_id);
                $this->db->set('medico_agenda', $medico_id);
            }
            $this->db->set('tipo_agenda', 'normal');
            $this->db->set('agenda_exames_nome_id', $sala_id);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

//            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('observacoes', $obs);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'EXAME');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $agenda_exames_id = $this->db->insert_id();
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravargeral($horarioagenda_id, $agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $sala_id, $id, $medico_id, $empresa_id, $obs = null, $tipo) {
        try {

            $index = date("Y-m-d", strtotime(str_replace("/", "-", $index)));

            /* inicia o mapeamento no banco */
            $this->db->set('horarioagenda_id', $agenda_id);
            $this->db->set('horario_id', $horarioagenda_id);
            $this->db->set('inicio', $horaconsulta);
            $this->db->set('fim', $horaverifica);
            $this->db->set('nome', $nome);
            $this->db->set('data_inicio', $datainicial);
            $this->db->set('data_fim', $datafinal);
            $this->db->set('data', $index);
            $this->db->set('nome_id', $id);
            $this->db->set('tipo_consulta_id', $_POST['txttipo']);
            if ($medico_id != '') {
                $this->db->set('medico_consulta_id', $medico_id);
                $this->db->set('medico_agenda', $medico_id);
            }
            $this->db->set('tipo_agenda', 'normal');
            $this->db->set('agenda_exames_nome_id', $sala_id);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

//            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('observacoes', $obs);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', $tipo);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $agenda_exames_id = $this->db->insert_id();
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsulta($horario_id, $agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id, $observacoes, $empresa_id) {
        try {

            $index = date("Y-m-d", strtotime(str_replace("/", "-", $index)));
            /* inicia o mapeamento no banco */
            $this->db->set('horarioagenda_id', $agenda_id);
            $this->db->set('horario_id', $horario_id);
            $this->db->set('inicio', $horaconsulta);
            $this->db->set('fim', $horaverifica);
            $this->db->set('nome', $nome);
            $this->db->set('data_inicio', $datainicial);
            $this->db->set('data_fim', $datafinal);
            $this->db->set('data', $index);
            $this->db->set('tipo_consulta_id', $_POST['txttipo']);
            $this->db->set('nome_id', $id);
            $this->db->set('medico_consulta_id', $medico_id);
            $this->db->set('medico_agenda', $medico_id);
            $this->db->set('tipo_agenda', 'normal');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('observacoes', $observacoes);
            $this->db->set('tipo', 'CONSULTA');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $agenda_exames_id = $this->db->insert_id();
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarhorarioseditadosagendacriada($horario_id, $agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id, $empresa_id, $obs = null, $tipo, $sala_id, $tipo_consulta_id) {
        try {
//            die('morreu');

            $index = date("Y-m-d", strtotime(str_replace("/", "-", $index)));
            /* inicia o mapeamento no banco */
            $this->db->set('horarioagenda_id', (int) $agenda_id);
            $this->db->set('horarioagenda_editada_id', (int) $horario_id);
            $this->db->set('inicio', $horaconsulta);
            $this->db->set('fim', $horaverifica);
            $this->db->set('nome', $nome);
            $this->db->set('data_inicio', $datainicial);
            $this->db->set('data_fim', $datafinal);
            $this->db->set('data', $index);
            $this->db->set('nome_id', $id);
            $this->db->set('medico_consulta_id', (int) $medico_id);
            $this->db->set('medico_agenda', (int) $medico_id);
            $this->db->set('tipo_agenda', 'editada');
            $this->db->set('agenda_editada', 't');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($tipo == "EXAME") {
                $this->db->set('agenda_exames_nome_id', (int) $sala_id);
            } else {
                $this->db->set('tipo_consulta_id', (int) $tipo_consulta_id);
            }

            $this->db->set('observacoes', $obs);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', $tipo);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_agenda_exames');
//            die;
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $agenda_exames_id = $this->db->insert_id();
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarespecialidade($horario_id, $agenda_id, $horaconsulta, $horaverifica, $nome, $datainicial, $datafinal, $index, $medico_id, $id, $empresa_id, $obs = null) {
        try {

            $index = date("Y-m-d", strtotime(str_replace("/", "-", $index)));
            /* inicia o mapeamento no banco */
            $this->db->set('horarioagenda_id', $agenda_id);
            $this->db->set('horario_id', $horario_id);
            $this->db->set('inicio', $horaconsulta);
            $this->db->set('fim', $horaverifica);
            $this->db->set('nome', $nome);
            $this->db->set('data_inicio', $datainicial);
            $this->db->set('data_fim', $datafinal);
            $this->db->set('data', $index);
            $this->db->set('tipo_consulta_id', $_POST['txtespecialidade']);
            $this->db->set('nome_id', $id);
            $this->db->set('medico_consulta_id', $medico_id);
            $this->db->set('medico_agenda', $medico_id);
            $this->db->set('tipo_agenda', 'normal');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

//            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('observacoes', $obs);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('tipo', 'FISIOTERAPIA');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_agenda_exames');
//            die;
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $agenda_exames_id = $this->db->insert_id();
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravardicom($data) {
        try {

            /* inicia o mapeamento no banco */
            $this->db->set('wkl_aetitle', $data['titulo']);
            $this->db->set('wkl_procstep_startdate', $data['data']);
            $this->db->set('wkl_procstep_starttime', $data['hora']);
            $this->db->set('wkl_modality', $data['tipo']);
            $this->db->set('wkl_perfphysname', $data['tecnico']);
            $this->db->set('wkl_procstep_descr', $data['procedimento']);
            $this->db->set('wkl_procstep_id', $data['procedimento_tuss_id']);
            $this->db->set('wkl_reqprocid', $data['procedimento_tuss_id_solicitado']);
            $this->db->set('wkl_reqprocdescr', $data['procedimento_solicitado']);
            $this->db->set('wkl_studyinstuid', $data['identificador_id']);
            $this->db->set('wkl_accnumber', $data['pedido_id']);
            $this->db->set('wkl_reqphysician', $data['solicitante']);
            $this->db->set('wkl_refphysname', $data['referencia']);
            $this->db->set('wkl_patientid', $data['paciente_id']);
            $this->db->set('wkl_patientname', $data['paciente']);
            $this->db->set('wkl_patientbirthdate', $data['nascimento']);
            $this->db->set('wkl_patientsex', $data['sexo']);
            $this->db->set('wkl_exame_id', $data['exame_id']);

            $this->db->insert('tb_integracao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $agenda_exames_id = $this->db->insert_id();
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function removendoprocedimentoduplicadoagendaeditada() {

        $sql = "SELECT horarioagenda_id, inicio, fim, nome, data, medico_agenda
                      FROM ponto.tb_agenda_exames
                    WHERE (encaixe != 't' OR encaixe IS NULL)
                    GROUP BY horarioagenda_id, inicio, fim, nome, data, medico_agenda
                    HAVING COUNT(*) > 1";

        $return = $this->db->query($sql);
        $return = $return->result();

        foreach ($return as $value) {
            $this->db->where('horarioagenda_id', $value->horarioagenda_id);
            $this->db->where('inicio', $value->inicio);
            $this->db->where('fim', $value->fim);
            $this->db->where('data', $value->data);
            $this->db->where('nome', $value->nome);
            $this->db->where('medico_agenda', $value->medico_agenda);
            $this->db->where('paciente_id IS NULL');
            $this->db->delete('tb_agenda_exames');
        }
    }

    function fecharfinanceiro() {
//        try {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $data = date("Y-m-d");

        $credor_devedor_id = $_POST['relacao'];
        $conta_id = $_POST['conta'];
        $convenio_id = $_POST['convenio'];
        $data_inicio = $_POST['data1'];
        $data_fim = $_POST['data2'];

        $this->db->select('ir, pis, cofins, csll, iss, valor_base, entrega, pagamento');
        $this->db->from('tb_convenio');
        $this->db->where("convenio_id", $convenio_id);
        $query = $this->db->get();

        $returno = $query->result();
        $pagamento = $returno[0]->pagamento;
        $pagamentodata = substr($data, 0, 7) . "-" . $returno[0]->entrega;

//        var_dump($pagamentodata);

        $data30 = date('Y-m-d', strtotime("+$pagamento days", strtotime($pagamentodata)));
        $ir = $returno[0]->ir / 100;
        $pis = $returno[0]->pis / 100;
        $cofins = $returno[0]->cofins / 100;
        $csll = $returno[0]->csll / 100;
        $iss = $returno[0]->iss / 100;
        $valor_base = $returno[0]->valor_base;
        $dineiro = str_replace(",", ".", str_replace(".", "", $_POST['dinheiro']));
        $dineirodescontado = $dineiro;

        if ($conta_id == "" || $credor_devedor_id == "" || $pagamento == "" || $pagamentodata == "") {
            $financeiro = -1;
        } else {


            if ($dineiro >= $valor_base) {
                $dineirodescontado = $dineirodescontado - ($dineiro * $ir);
            }
            $dineirodescontado = $dineirodescontado - ($dineiro * $pis);
            $dineirodescontado = $dineirodescontado - ($dineiro * $cofins);
            $dineirodescontado = $dineirodescontado - ($dineiro * $csll);
            $dineirodescontado = $dineirodescontado - ($dineiro * $iss);
            $sql = "UPDATE ponto.tb_agenda_exames
SET operador_financeiro = $operador_id, data_financeiro= '$horario', financeiro = 't'
where agenda_exames_id in (SELECT ae.agenda_exames_id
FROM ponto.tb_agenda_exames ae 
LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id 
LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id 
LEFT JOIN ponto.tb_exames e ON e.agenda_exames_id = ae.agenda_exames_id 
LEFT JOIN ponto.tb_ambulatorio_laudo al ON al.exame_id = e.exames_id 
LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id 
WHERE ae.cancelada = 'false' 
AND ae.confirmado >= 'true' 
AND ae.data >= '$data_inicio' 
AND ae.data <= '$data_fim' 
AND c.convenio_id = $convenio_id 
ORDER BY ae.agenda_exames_id)";

//            var_dump($data30); die;
            $this->db->query($sql);

            $this->db->set('valor', $dineirodescontado);
            $this->db->set('devedor', $credor_devedor_id);
            $this->db->set('data', $data30);
            $this->db->set('tipo', 'FATURADO CONVENIO');
            $this->db->set('observacao', "PERIODO DE $data_inicio ATE $data_fim");
            $this->db->set('conta', $conta_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_financeiro_contasreceber');
        }


//        die;
    }

    private
            function instanciar($agenda_exames_id) {

        if ($agenda_exames_id != 0) {
            $this->db->select('agenda_exames_id, horarioagenda_id, paciente_id, procedimento_tuss_id, inicio, fim, nome, ativo, confirmado, data_inicio, data_fim');
            $this->db->from('tb_agenda_exames');
            $this->db->where("agenda_exames_id", $agenda_exames_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_agenda_exames_id = $agenda_exames_id;

            $this->_horarioagenda_id = $return[0]->horarioagenda_id;
            $this->_paciente_id = $return[0]->paciente_id;
            $this->_procedimento_tuss_id = $return[0]->procedimento_tuss_id;
            $this->_inicio = $return[0]->inicio;
            $this->_fim = $return[0]->fim;
            $this->_nome = $return[0]->nome;
            $this->_ativo = $return[0]->ativo;
            $this->_confirmado = $return[0]->confirmado;
            $this->_data_inicio = $return[0]->data_inicio;
            $this->_data_fim = $return[0]->data_fim;
        } else {
            $this->_agenda_exames_id = null;
        }
    }

}

?>
