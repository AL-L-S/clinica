<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class solicita_cirurgia_model extends BaseModel {

    var $_internacao_motivosaida_id = null;
    var $_localizacao = null;
    var $_nome = null;

    function solicita_cirurgia_model($internacao_motivosaida_id = null) {
        parent::Model();
        if (isset($internacao_motivosaida_id)) {
            $this->instanciar($internacao_motivosaida_id);
        }
    }

    private function instanciar($internacao_motivosaida_id) {
        if ($internacao_motivosaida_id != 0) {

            $this->db->select('internacao_motivosaida_id,
                            nome');
            $this->db->from('tb_solicitacao_cirurgia');
            $this->db->where('ativo', 'true');
            $this->db->where('internacao_motivosaida_id', $internacao_motivosaida_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_internacao_motivosaida_id = $internacao_motivosaida_id;
            $this->_nome = $return[0]->nome;
        }
    }

    function listamotivosaida($args = array()) {
        $this->db->select(' internacao_motivosaida_id,
                            nome');
        $this->db->from('tb_solicitacao_cirurgia');
        $this->db->where('ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('nome ilike', "%" . $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listamotivosaidapacientes() {
        $this->db->select('nome,
                internacao_motivosaida_id');
        $this->db->from('tb_solicitacao_cirurgia');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitomotivosaida() {
        $this->db->select('internacao_leito_id,
                           nome,
                           tipo,
                           condicao,
                           enfermaria_id,
                           ativo');
        $this->db->from('tb_internacao_leito');
        $return = $this->db->get();
        return $return->result();
    }

    function grauparticipacao() {
        $this->db->select("grau_participacao_id as grau_id, 
                           codigo || ' - ' || descricao as grau_participacao,
                           codigo");
        $this->db->from('tb_grau_participacao ec');
        $this->db->where('ec.ativo', 't');
        $this->db->orderby('ec.codigo');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitocirugia() {
        $this->db->select('internacao_leito_id,
                           nome,
                           tipo,
                           condicao,
                           enfermaria_id,
                           ativo');
        $this->db->from('tb_internacao_leito');
        $this->db->where('condicao', 'Cirurgico');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listasolicitacao($args = array()) {

        $this->db->select(' p.paciente_id,
                            p.nome,
                            sc.procedimento_id,
                            sc.solicitacao_cirurgia_id,
                            pt.descricao,
                            sc.data_prevista');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = sc.procedimento_id ');
        $this->db->where('pc.ativo', 't');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->where('pt.ativo', 't');

        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('nome ilike', "%" . $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listarprocedimentosagrupador($procedimento) {
        $this->db->select("procedimento_tuss_id, convenio_id");
        $this->db->from('tb_procedimento_convenio');
        $this->db->where('procedimento_convenio_id', $procedimento);
        $return = $this->db->get()->result();
        
        $this->db->select("pc.procedimento_convenio_id");
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->where('pc.ativo', 't');
        $this->db->where("pc.convenio_id", $return[0]->convenio_id);
        $this->db->where("pc.procedimento_tuss_id IN (
                SELECT procedimento_tuss_id FROM ponto.tb_procedimentos_agrupados_ambulatorial 
                WHERE procedimento_agrupador_id = ".$return[0]->procedimento_tuss_id."
            )
        ");
        $procedimentos = $this->db->get()->result();
        
        return $procedimentos;
    }

    function verificasolicitacaoprocedimentorepetidos() {
        $this->db->select('');
        $this->db->from('tb_solicitacao_cirurgia_procedimento');
        $this->db->where('ativo', 't');
        $this->db->where('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
        $this->db->where('procedimento_tuss_id', $_POST['procedimentoID']);
        $return = $this->db->get();
        return $return->result();
    }

    function listarvalorprocedimentocadastrar() {
        $this->db->select('valortotal');
        $this->db->from('tb_procedimento_convenio');
        $this->db->where('ativo', 't');
        $this->db->where('procedimento_convenio_id', $_POST['procedimentoID']);
        $return = $this->db->get();
        return $return->result();
    }

    function mostrarsaidapaciente($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.nome as paciente,
                           m.nome as motivosaida,
                           i.motivo_saida,
                           m.internacao_motivosaida_id,
                           p.paciente_id,
                           i.data_internacao,
                           i.observacao_saida,
                           i.leito,
                           p.sexo,
                           p.nascimento');
        $this->db->from('tb_internacao i, tb_paciente p, tb_operador o,tb_solicitacao_cirurgia m');
        $this->db->where('i.internacao_id', $internacao_id);
        $this->db->where('p.paciente_id = i.paciente_id');
        $this->db->where('o.operador_id = i.medico_id');

        // $this->db->where('m.internacao_motivosaida_id = i.motivo_saida ');

        $return = $this->db->get();
        return $return->result();
    }

    function excluirsolicitacaocirurgia($solicitacao_id) {
        $this->db->set('excluido', 't');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->update('tb_solicitacao_cirurgia');
    }

    function excluirsolicitacaoprocedimento($solicitacao_procedimento_id) {
        $this->db->set('ativo', 'f');
        $this->db->where('solicitacao_cirurgia_procedimento_id', $solicitacao_procedimento_id);
        $this->db->update('tb_solicitacao_cirurgia_procedimento');
    }

    function excluirsolicitacaomaterial($solicitacao_material_id) {
        $this->db->set('ativo', 'f');
        $this->db->where('solicitacao_cirurgia_material_id', $solicitacao_material_id);
        $this->db->update('tb_solicitacao_cirurgia_material');
    }

    function gravarsolicitacaocirurgia() {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('internacao_id', $_POST['internacao_id']);
        $this->db->set('procedimento_id', $_POST['procedimentoID']);
        $this->db->set('data_solicitacao', $horario);
        $this->db->set('operador_solicitacao', $operador_id);
        $this->db->insert('tb_solicitacao_cirurgia');
    }

    function solicitacirurgia($internacao_id) {

        $this->db->select('p.nome as paciente,
                           i.internacao_id,
                           p.paciente_id,
                           i.data_internacao,
                           i.leito,
                           p.sexo,
                           p.nascimento,
                           ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ');
        $this->db->where('i.internacao_id', $internacao_id);
        $this->db->where('i.ativo', 't');
        $this->db->where('p.paciente_id = i.paciente_id');

        $return = $this->db->get();
        return $return->result();
    }

    function carregarsolicitacaoprocedimento($convenio_id) {

        $this->db->select('pc.procedimento_convenio_id,
                           pc.valortotal,
                           pt.codigo,
                           pt.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('pt.grupo', 'CIRURGICO');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pc.convenio_id', $convenio_id);
        $return = $this->db->get();
        return $return->result();
    }

    function verificaprocedimentoagrupador($procedimento_tuss_id) {
        $this->db->select('grupo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
        $this->db->where('pt.agrupador', 't');
        $return = $this->db->get()->result();
        
        if($return[0]->grupo == 'CIRURGICO'){
            return true;
        }
        else{
            return false;
        }
    }

    function verificamaterialagrupador($procedimento_tuss_id) {


        $this->db->select('grupo');
        $this->db->from('tb_procedimento_tuss pt');
        $this->db->where('pt.procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->where('pt.agrupador', 't');
        $return = $this->db->get()->result();
        
        if($return[0]->grupo == 'OPME'){
            return true;
        }
        else{
            return false;
        }
    }

    function carregarsolicitacaoagrupadormaterial() {


        $this->db->select('pt.codigo,
                           pt.procedimento_tuss_id,
                           pt.nome');
        $this->db->from('tb_procedimento_tuss pt');
        $this->db->where("pt.grupo = 'OPME'");
        $this->db->where('pt.ativo', 'true');
        $this->db->where('pt.agrupador', 'true');
//        $this->db->where('pc.convenio_id', $convenio_id);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarsolicitacaomaterial() {


        $this->db->select('pt.codigo,
                           pt.procedimento_tuss_id,
                           pt.nome');
        $this->db->from('tb_procedimento_tuss pt');
        $this->db->where('pt.grupo', 'OPME');
        $this->db->where('pt.ativo', 'true');
//        $this->db->where('pc.convenio_id', $convenio_id);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarsolicitacaoagrupador($convenio_id = null) {

        $this->db->select('pc.procedimento_convenio_id,
                           pt.codigo,
                           pt.procedimento_tuss_id,
                           pt.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->where("pt.grupo = 'CIRURGICO'");
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pc.agrupador', 'true');
        if($convenio_id != null){
            $this->db->where('pc.convenio_id', $convenio_id);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function solicitacirurgiaconsulta($exame_id) {

        $this->db->select('p.nome as paciente,
                           p.paciente_id');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id', 'left');
        $this->db->where('e.exames_id', $exame_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listamotivosaidaautocomplete($parametro = null) {
        $this->db->select('internacao_motivosaida_id,
                            nome,
                            localizacao');
        $this->db->from('tb_solicitacao_cirurgia');
        $this->db->where('ativo', 'true');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaosmateriais($solicitacao_id) {
        $this->db->select('scp.solicitacao_cirurgia_material_id as solicitacao_material_id, scp.quantidade, scp.valor_unitario, scp.observacao,
                           pt.nome');
        $this->db->from('tb_solicitacao_cirurgia_material scp');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = scp.procedimento_tuss_id', 'left');
        $this->db->where('scp.ativo', 'true');
        $this->db->where('scp.solicitacao_cirurgia_id', $solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaosprocedimentos($solicitacao_id) {
        $this->db->select('scp.solicitacao_cirurgia_procedimento_id as solicitacao_procedimento_id, scp.quantidade, scp.valor_unitario,
                           c.nome as convenio,
                           pt.nome');
        $this->db->from('tb_solicitacao_cirurgia_procedimento scp');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = scp.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('scp.ativo', 'true');
        $this->db->where('scp.solicitacao_cirurgia_id', $solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaosprocedimentosorcamento($solicitacao_id) {
        $this->db->select('scp.solicitacao_cirurgia_procedimento_id as solicitacao_procedimento_id, scp.quantidade, scp.valor_unitario,
                           c.nome as convenio,
                           pt.nome');
        $this->db->from('tb_solicitacao_cirurgia_procedimento scp');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = scp.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('scp.ativo', 'true');
        $this->db->where('c.dinheiro', 'true');
        $this->db->where('scp.solicitacao_cirurgia_id', $solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaosprocedimentosconvenio($solicitacao_id) {
        $this->db->select('scp.solicitacao_cirurgia_procedimento_id as solicitacao_procedimento_id, scp.quantidade, scp.valor_unitario,
                           c.nome as convenio,
                           pt.nome');
        $this->db->from('tb_solicitacao_cirurgia_procedimento scp');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = scp.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('scp.ativo', 'true');
        $this->db->where('c.dinheiro', 'false');
        $this->db->where('scp.solicitacao_cirurgia_id', $solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluirmotivosaida($internacao_motivosaida_id) {


        $this->db->set('ativo', 'f');
        $this->db->where('internacao_motivosaida_id', $internacao_motivosaida_id);
        $this->db->update('tb_solicitacao_cirurgia');
    }

    function gravarsaida() {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        //Tabela internação alteração
        if ($_POST['motivosaida'] == 'transferencia') {
            $this->db->set('ativo', 'f');
            $this->db->set('hospital_transferencia', $_POST['hospital']);
            $this->db->set('observacao_saida', $_POST['observacao']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('data_saida', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_id', $_POST['idpaciente']);
            $this->db->update('tb_internacao');
        } else {
            $this->db->set('ativo', 'f');
            $this->db->set('motivo_saida', $_POST['motivosaida']);
            $this->db->set('observacao_saida', $_POST['observacao']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('data_saida', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('paciente_id', $_POST['idpaciente']);
            $this->db->update('tb_internacao');
        }
        //Tabela Ocupação alteração
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('ocupado', 'f');
        $this->db->where('paciente_id', $_POST['idpaciente']);
        $this->db->update('tb_internacao_ocupacao');

        //Tabela internacao_leito

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('ativo', 't');
        $this->db->where('internacao_leito_id', $_POST['leito']);
        $this->db->update('tb_internacao_leito');
    }

    function gravarmotivosaida() {

        try {
            $this->db->set('nome', $_POST['nome']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_motivosaida_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_solicitacao_cirurgia');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $internacao_motivosaida_id = $this->db->insert_id();
            }
            else { // update
                $internacao_motivosaida_id = $_POST['internacao_motivosaida_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_motivosaida_id', $internacao_motivosaida_id);
                $this->db->update('tb_solicitacao_cirurgia');
            }


            return $internacao_motivosaida_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function listarprocedimentoscirurgia($solicitacao_id) {
        $this->db->select('pt.nome,
                           pc.procedimento_tuss_id,
                           c.nome as convenio,
                           pt.codigo');
        $this->db->from('tb_solicitacao_cirurgia_procedimento cp');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = cp.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->where('cp.ativo', 'true');

        $return = $this->db->get();
        return $return->result();
    }

    function burcarempresa() {
        $empresa = $this->session->userdata('empresa_id');
        $this->db->select('razao_social,
                           cnpj,
                           logradouro,
                           numero,
                           bairro,
                           telefone');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa);

        $return = $this->db->get();
        return $return->result();
    }

    function listardadossolicitacaoautorizar($solicitacao_id) {
        $this->db->select('sc.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           p.telefone,
                           sc.data_prevista,
                           sc.observacao,
                           sc.hora_prevista,
                           sc.hora_prevista_fim,
                           sc.solicitacao_cirurgia_id,
                           sc.via,
                           sc.guia_id,
                           h.nome as hospital,
                           h.valor_taxa,
                           c.nome as convenio,
                           o.nome as solicitante');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id', 'left');
        $this->db->join('tb_hospital h', 'h.hospital_id = sc.hospital_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_solicitante', 'left');
        $this->db->join('tb_solicitacao_orcamento so', 'so.solicitacao_cirurgia_id = sc.solicitacao_cirurgia_id', 'left');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaocirurgicamaterialopme($solicitacao_id) {
        $this->db->select('sc.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           sc.leito,
                           sc.via,
                           p.telefone,
                           p.convenionumero,
                           h.nome as hospital,
                           h.valor_taxa,
                           h.cnpj,
                           c.nome as convenio,
                           c.registroans,
                           c.codigoidentificador,
                           c.caminho_logo,
                           o.nome as solicitante,
                           o.cbo_ocupacao_id as cbo,
                           o.conselho,
                           o.telefone,
                           o.celular,
                           o.email,
                           ms.codigo_ibge,
                           sc.observacao,
                           sc.convenio as convenio_id,
                           sc.guia_id,
                           sc.data_prevista,
                           sc.data_cadastro,
                           sc.data_autorizacao');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id', 'left');
        $this->db->join('tb_hospital h', 'h.hospital_id = sc.hospital_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_solicitante', 'left');
        $this->db->join('tb_municipio ms', 'ms.municipio_id = o.municipio_id', 'left');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaocirurgicaconveniospsadt($solicitacao_id) {
        $this->db->select('sc.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           sc.leito,
                           sc.via,
                           p.telefone,
                           p.convenionumero,
                           h.nome as hospital,
                           h.valor_taxa,
                           h.cnpj,
                           c.nome as convenio,
                           c.registroans,
                           c.codigoidentificador,
                           c.caminho_logo,
                           o.nome as solicitante,
                           o.cbo_ocupacao_id as cbo,
                           o.conselho,
                           ms.codigo_ibge,
                           sc.observacao,
                           sc.convenio as convenio_id,
                           sc.guia_id,
                           sc.data_prevista,
                           sc.data_cadastro,
                           sc.data_autorizacao,
                           al.texto as indicacao_clinica');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id', 'left');
        $this->db->join('tb_hospital h', 'h.hospital_id = sc.hospital_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_solicitante', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.ambulatorio_laudo_id = sc.ambulatorio_laudo_id', 'left');
        $this->db->join('tb_municipio ms', 'ms.municipio_id = o.municipio_id', 'left');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listardadossolicitacaoorcamentoimpressao($solicitacao_id) {
        $this->db->select('sc.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           sc.leito,
                           sc.via,
                           p.telefone,
                           h.nome as hospital,
                           h.valor_taxa,
                           c.nome as convenio,
                           o.nome as solicitante');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id', 'left');
        $this->db->join('tb_hospital h', 'h.hospital_id = sc.hospital_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_solicitante', 'left');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listardadossolicitacaoorcamento($solicitacao_id) {
        $this->db->select('sc.paciente_id,
                           p.nome as paciente,
                           sc.via,
                           p.celular,
                           p.telefone,
                           h.nome as hospital,
                           c.nome as convenio,
                           o.nome as solicitante');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id', 'left');
        $this->db->join('tb_hospital h', 'h.hospital_id = sc.hospital_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_solicitante', 'left');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listardadossolicitacaoorcamentoconvenio($solicitacao_id) {
        $this->db->select('sc.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           sc.via,
                           p.telefone,
                           h.nome as hospital,
                           c.nome as convenio,
                           o.nome as solicitante');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id', 'left');
        $this->db->join('tb_hospital h', 'h.hospital_id = sc.hospital_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_solicitante', 'left');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);
//        $this->db->where('c.dinheiro', $solicitacao_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentosolicitacaocirurgicaorcamento($solicitacao_id) {
        $this->db->select('pt.nome as procedimento,
                           pt.codigo,
                           scp.valor as valortotal,
                           scp.via,
                           scp.quantidade, scp.valor_unitario,
                           c.nome as convenio,
                           pc.procedimento_convenio_id,
                           scp.solicitacao_cirurgia_procedimento_id');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_solicitacao_cirurgia_procedimento scp', 'scp.solicitacao_cirurgia_id = sc.solicitacao_cirurgia_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = scp.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->where('scp.ativo', 't');
        $this->db->where('c.dinheiro', 't');

        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentosolicitacaocirurgica($solicitacao_id) {
        $this->db->select('pt.nome as procedimento,
                           pt.codigo,
                           pc.valortotal,
                           scp.valor as valortotal,
                           scp.via,
                           scp.quantidade, scp.valor_unitario,
                           c.nome as convenio,
                           pc.procedimento_convenio_id,
                           scp.solicitacao_cirurgia_procedimento_id');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_solicitacao_cirurgia_procedimento scp', 'scp.solicitacao_cirurgia_id = sc.solicitacao_cirurgia_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = scp.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->where('scp.ativo', 't');
//        $this->db->where('c.dinheiro', 't');

        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentosolicitacaocirurgicaconvenio($solicitacao_id) {
        $this->db->select('pt.nome as procedimento,
                           pt.codigo,
                           scp.valor as valortotal,
                           scp.via,
                           scp.quantidade, scp.valor_unitario,
                           c.nome as convenio,
                           pc.procedimento_convenio_id,
                           scp.solicitacao_cirurgia_procedimento_id');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_solicitacao_cirurgia_procedimento scp', 'scp.solicitacao_cirurgia_id = sc.solicitacao_cirurgia_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = scp.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->where('scp.ativo', 't');
        $this->db->where('c.dinheiro', 'f');

        $return = $this->db->get();
        return $return->result();
    }

    function listarmateriaisguiacirurgicaopme($solicitacao_id) {        
        $this->db->select('scp.solicitacao_cirurgia_material_id as solicitacao_material_id, 
                           scp.quantidade, 
                           scp.valor_unitario, 
                           scp.observacao,
                           pt.nome,
                           pt.codigo');
        $this->db->from('tb_solicitacao_cirurgia_material scp');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = scp.procedimento_tuss_id', 'left');
        $this->db->where('scp.ativo', 'true');
        $this->db->where('scp.solicitacao_cirurgia_id', $solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentoguiacirurgicaconvenio($solicitacao_id) {
        $this->db->select('pt.nome as procedimento,
                           pt.codigo,
                           scp.valor as valortotal,
                           scp.via,
                           scp.quantidade, scp.valor_unitario,
                           c.nome as convenio,
                           pc.procedimento_convenio_id,
                           scp.solicitacao_cirurgia_procedimento_id');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_solicitacao_cirurgia_procedimento scp', 'scp.solicitacao_cirurgia_id = sc.solicitacao_cirurgia_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = scp.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->where('scp.ativo', 't');
        $this->db->where('c.dinheiro', 'f');

        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentosolicitacaocirurgicaeditar($solicitacao_id) {
        $this->db->select('pt.nome as procedimento,
                           pt.codigo,
                           c.nome as convenio,
                           c.dinheiro,
                           scp.valor,
                           scp.quantidade, scp.valor_unitario,
                           scp.via,
                           pc.procedimento_convenio_id,
                           scp.solicitacao_cirurgia_procedimento_id');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_solicitacao_cirurgia_procedimento scp', 'scp.solicitacao_cirurgia_id = sc.solicitacao_cirurgia_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = scp.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->where('scp.ativo', 't');

        $return = $this->db->get();
        return $return->result();
    }

    function listarconvenios() {

        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' c.convenio_id,
                            c.nome,
                            c.dinheiro,
                            c.conta_id');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_convenio_empresa ce', 'ce.convenio_id = c.convenio_id', 'left');
        $this->db->where("c.ativo", 'true');
        $this->db->where("ce.empresa_id", $empresa_id);
        $this->db->where("ce.ativo", 'true');
        $this->db->where("c.dinheiro", 'false');
        $this->db->orderby("c.nome");
        $query = $this->db->get();
        $return = $query->result();

        return $return;
    }

    function listarconveniostodos() {

        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' c.convenio_id,
                            c.nome,
                            c.dinheiro,
                            c.conta_id');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_convenio_empresa ce', 'ce.convenio_id = c.convenio_id', 'left');
        $this->db->where("c.ativo", 'true');
        $this->db->where("ce.empresa_id", $empresa_id);
        $this->db->where("ce.ativo", 'true');
//        $this->db->where("ce.dinheiro", 'false');
        $this->db->orderby("c.nome");
        $query = $this->db->get();
        $return = $query->result();

        return $return;
    }

    function listarconveniosdinheiro() {

        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' c.convenio_id,
                            c.nome,
                            c.dinheiro,
                            c.conta_id');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_convenio_empresa ce', 'ce.convenio_id = c.convenio_id', 'left');
        $this->db->where("c.ativo", 'true');
        $this->db->where("ce.empresa_id", $empresa_id);
        $this->db->where("ce.ativo", 'true');
        $this->db->where("ce.dinheiro", 'true');
        $this->db->orderby("c.nome");
        $query = $this->db->get();
        $return = $query->result();

        return $return;
    }

    function listarequipe($equipe_id) {
        $this->db->select('ec.equipe_cirurgia_id,
                           ec.nome');
        $this->db->from('tb_equipe_cirurgia ec');
        $this->db->where('ec.equipe_cirurgia_id', $equipe_id);
//        $this->db->where('ec.ativo', 't');

        $return = $this->db->get();
        return $return->result();
    }

    function listarequipeoperadores($solicitacaocirurgia_id) {
        $this->db->select('ec.equipe_cirurgia_operadores_id,
                           gp.descricao as funcao,
                           o.nome as medico');
        $this->db->from('tb_equipe_cirurgia_operadores ec');
        $this->db->join('tb_operador o', 'o.operador_id = ec.operador_responsavel', 'left');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = ec.funcao', 'left');
        $this->db->where('ec.solicitacao_cirurgia_id', $solicitacaocirurgia_id);
        $this->db->where('ec.ativo', 't');
        $this->db->where('gp.ativo', 't');
        $this->db->orderby("gp.codigo");

        $return = $this->db->get();
        return $return->result();
    }

    function gravarnovasolicitacao() {

        try {
//            var_dump($_POST['ambulatorio_laudo_id']); die;
            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('data_prevista', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_prevista']))));
            $this->db->set('hora_prevista', date("H:i:s", strtotime(str_replace('/', '-', $_POST['hora_inicio']))));
            $this->db->set('hora_prevista_fim', date("H:i:s", strtotime(str_replace('/', '-', $_POST['hora_fim']))));
            if($_POST['ambulatorio_laudo_id'] != ''){
                $this->db->set('ambulatorio_laudo_id', $_POST['ambulatorio_laudo_id']);
            }
            $this->db->set('leito', $_POST['leito']);
            $this->db->set('observacao', $_POST['observacao']);
            $this->db->set('paciente_id', $_POST['txtNomeid']);
            $this->db->set('medico_solicitante', $_POST['medicoagenda']);
            $this->db->set('convenio', $_POST['convenio']);
            $this->db->set('hospital_id', $_POST['hospital_id']);
            if (isset($_POST['orcamento'])) {
                $this->db->set('orcamento', 'true');
            } else {
                $this->db->set('orcamento', 'false');
            }
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_solicitacao_cirurgia');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            }

            $solicitacao_id = $this->db->insert_id();
            return $solicitacao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarsolicitacaoeditarprocedimento($guia_id, $solicitacao_id) {

        try {
//            var_dump($_POST);die;

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if (isset($_POST['quantidade'])) {
                $this->db->set('quantidade', $_POST['quantidade']);
                $quantidade = $_POST['quantidade'];
            } else {
                $this->db->set('quantidade', 1);
                $quantidade = 1;
            }
            $this->db->set('valor_unitario', (float) $_POST['valor1']);
            $this->db->set('valor', (float) $_POST['valor1'] * $quantidade);
            $this->db->set('solicitacao_cirurgia_id', $solicitacao_id);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            $this->db->set('via', $_POST['via']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_solicitacao_cirurgia_procedimento');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluirprocedimentocirurgico($solicitacao_cirurgia_procedimento_id, $guia_id, $solicitacao_id) {

        try {
//            var_dump($_POST['procedimento_id']);die;

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('ativo', 'f');
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('data_atualizacao', $horario);
            $this->db->where('solicitacao_cirurgia_procedimento_id', $solicitacao_cirurgia_procedimento_id);
            $this->db->update('tb_solicitacao_cirurgia_procedimento');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarsolicitacaoprocedimento($valor) {

        try {
//            var_dump($valor);die;

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            if (isset($_POST['quantidade'])) {
                $this->db->set('quantidade', $_POST['quantidade']);
            } else {
                $this->db->set('quantidade', 1);
            }
            
            $this->db->set('valor', $valor[0]->valortotal * $_POST['quantidade']);
            $this->db->set('valor_unitario', $valor[0]->valortotal);
            
            $this->db->set('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
            $this->db->set('procedimento_tuss_id', $_POST['procedimentoID']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_solicitacao_cirurgia_procedimento');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarsolicitacaoprocedimentoalterar() {

        try {
//            var_dump($_POST['procedimento_id']);die;

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if (isset($_POST['quantidade'])) {
                $this->db->set('quantidade', $_POST['quantidade']);
                $quantidade = $_POST['quantidade'];
            } else {
                $this->db->set('quantidade', 1);
                $quantidade = 1;
            }
            $this->db->set('valor_unitario', $_POST['valor1']);
            $this->db->set('valor', $_POST['valor1'] * $quantidade);
            $this->db->set('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
            $this->db->set('procedimento_tuss_id', $_POST['procedimentoID']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_solicitacao_cirurgia_procedimento');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarsolicitacaomateriaisagrupador() {

        try {
            $this->db->set('fornecedor_id', $_POST['fornecedor_id']);
            $this->db->where('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
            $this->db->update('tb_solicitacao_cirurgia');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            
            $this->db->select("procedimento_tuss_id");
            $this->db->from('tb_procedimentos_agrupados_ambulatorial paa');
            $this->db->where('procedimento_agrupador_id', $_POST['material_id']);
            $this->db->where('ativo', 't');
            $return = $this->db->get()->result();
            
            foreach($return as $value){
                $this->db->set('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
                $this->db->set('quantidade', $_POST['qtde1']);
                $this->db->set('observacao', $_POST['observacao']);
                $this->db->set('procedimento_tuss_id', $value->procedimento_tuss_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_solicitacao_cirurgia_material');
            }
            
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarsolicitacaomateriais() {

        try {
//            var_dump($_POST);
//            die;
            $this->db->set('fornecedor_id', $_POST['fornecedor_id']);
            $this->db->where('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
            $this->db->update('tb_solicitacao_cirurgia');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('observacao', $_POST['observacao']);
            $this->db->set('procedimento_tuss_id', $_POST['material_id']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_solicitacao_cirurgia_material');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluiritemorcamento($orcamento_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('solicitacao_cirurgia_orcamento_id', $orcamento_id);
            $this->db->update('tb_solicitacao_cirurgia_orcamento');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            }
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluiritemequipe($cirurgia_operadores_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('equipe_cirurgia_operadores_id', $cirurgia_operadores_id);
//        $this->db->where('equipe_cirurgia_id', $equipe_id);
        $this->db->update('tb_equipe_cirurgia_operadores');
    }

    function excluiroperadorequipecirurgica($guia_id, $funcao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('funcao', $funcao_id);
        $this->db->where('guia_id', $guia_id);
//        $this->db->where('equipe_cirurgia_id', $equipe_id);
        $this->db->update('tb_agenda_exame_equipe');
    }

    function excluiroperadorequipecirurgicaeditar($guia_id, $funcao_id, $solicitacao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('funcao', $funcao_id);
        $this->db->where('guia_id', $guia_id);
//        $this->db->where('equipe_cirurgia_id', $equipe_id);
        $this->db->update('tb_agenda_exame_equipe');

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('funcao', $funcao_id);
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
//        $this->db->where('equipe_cirurgia_id', $equipe_id);
        $this->db->update('tb_equipe_cirurgia_operadores');
    }

    function listarmedicocirurgiaautocomplete($parametro = null) {
        $this->db->select('operador_id,
                           nome');
        $this->db->from('tb_operador');
        $this->db->where('consulta', 'true');
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function verificaorcamento($solicitacao_id) {
        $this->db->select('grau_participacao,
                           procedimento_tuss_id,
                           operador_responsavel,
                           valor,
                           solicitacao_cirurgia_orcamento_id');
        $this->db->from('tb_solicitacao_cirurgia_orcamento');
        $this->db->where('ativo', 'true');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function buscarnomesimpressao($solicitacao_id) {
        $this->db->select('o.nome as medico,
                           p.nome as paciente,
                           c.nome as convenio');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_agendado', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->where('sc.ativo', 'true');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentoorcamentofuncao($cirurgia_procedimento_id) {
        $this->db->select('o.nome as medico,
                           soe.valor,
                           gp.codigo,
                           gp.descricao');
        $this->db->from('tb_solicitacao_orcamento_equipe soe');
        $this->db->join('tb_operador o', 'o.operador_id = soe.operador_responsavel', 'left');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = soe.funcao', 'left');
        $this->db->where('soe.solicitacao_cirurgia_procedimento_id', $cirurgia_procedimento_id);
        $this->db->where('soe.ativo', 'true');
        $this->db->where('gp.ativo', 'true');
        $this->db->orderby('soe.funcao');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentoorcamentoconveniofuncao($cirurgia_procedimento_id) {
        $this->db->select('o.nome as medico,
                           soe.valor,
                           gp.codigo,
                           gp.descricao');
        $this->db->from('tb_solicitacao_orcamento_convenio_equipe soe');
        $this->db->join('tb_operador o', 'o.operador_id = soe.operador_responsavel', 'left');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = soe.funcao', 'left');
        $this->db->where('soe.solicitacao_cirurgia_procedimento_id', $cirurgia_procedimento_id);
        $this->db->where('soe.ativo', 'true');
        $this->db->where('gp.ativo', 'true');
        $this->db->orderby('soe.funcao');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentoorcamentoconveniofuncaocaixa($cirurgia_procedimento_id) {
        $this->db->select('o.nome as medico,
                           aee.*,
                           gp.codigo,
                           f.nome as forma_pagamento,
                           f2.nome as forma_pagamento_2,
                           f3.nome as forma_pagamento_3,
                           f4.nome as forma_pagamento_4,
                           gp.descricao');
        $this->db->from('tb_agenda_exame_equipe aee');
        $this->db->join('tb_operador o', 'o.operador_id = aee.operador_responsavel', 'left');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = aee.funcao', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = aee.forma_pagamento1', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = aee.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = aee.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = aee.forma_pagamento4', 'left');
        $this->db->where('aee.agenda_exames_id', $cirurgia_procedimento_id);
        $this->db->where('aee.ativo', 'true');
        $this->db->where('gp.ativo', 'true');
        $this->db->orderby('aee.funcao');
        $return = $this->db->get();
        return $return->result();
    }

    function impressaoorcamento($solicitacao_id) {

        $this->db->set('situacao', 'ENCAMINHADO_PACIENTE');
//        $this->db->set('situacao_convenio', 'ENCAMINHADO_CONVENIO');
        $this->db->set('encaminhado_paciente', 't');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->update('tb_solicitacao_cirurgia');


        $this->db->select('pt.nome as procedimento,
                           scp.solicitacao_cirurgia_procedimento_id as cirurgia_procedimento_id,
                           c.dinheiro,
                           c.nome as convenio,
                           scp.equipe_particular,
                           scp.valor');
        $this->db->from('tb_solicitacao_cirurgia_procedimento scp');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = scp.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('scp.ativo', 'true');
        $this->db->where('(c.dinheiro = true OR scp.equipe_particular = true)');
        $this->db->where('scp.solicitacao_cirurgia_id', $solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarsolicitacaorcamentoconvenioitens($orcamento_convenio_id) {

        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            // Trazendo os procedimentos
            $this->db->select(' horario_especial,
                                valor,
                                via,
                                equipe_particular,
                                solicitacao_cirurgia_procedimento_id');
            $this->db->from('tb_solicitacao_cirurgia_procedimento scp');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = scp.procedimento_tuss_id', 'left');
            $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
            $this->db->where("scp.ativo", 't');
            $this->db->where("c.dinheiro", 'f');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $this->db->orderby('valor DESC');
            $procedimentos = $this->db->get()->result();
//            echo "<pre>";
//            var_dump($procedimentos);
//            die;
            // Trazendo a lista com todos os integrantes da equipe cirurgica
            $this->db->select('leito');
            $this->db->from('tb_solicitacao_cirurgia');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $solicitacao = $this->db->get()->result();

            // Trazendo a lista com todos os integrantes da equipe cirurgica
            $this->db->select('funcao, gp.descricao, operador_responsavel');
            $this->db->from('tb_equipe_cirurgia_operadores eco');
            $this->db->join('tb_grau_participacao gp', 'gp.codigo = eco.funcao', 'left');
            $this->db->where('eco.ativo', 't');
            $this->db->where('gp.ativo', 't');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $equipe = $this->db->get()->result();

            // Trazendo o valor dos percentuais configurados
            $this->db->select(' leito_enfermaria,
                                leito_apartamento,
                                mesma_via,
                                via_diferente,
                                horario_especial,
                                valor,
                                valor_base');
            $this->db->from('tb_centrocirurgico_percentual_outros cpo');
            $this->db->where("ativo", 't');
            $query = $this->db->get();
            $return = $query->result();

            foreach ($return as $value) {

                if ($value->horario_especial == 't') {
                    $horario_especial = ($value->valor / 100);
                    continue;
                }

                if ($value->leito_enfermaria == 't') {
                    if ($value->mesma_via == 't') {
                        $enfermaria_mesma_via['maior'] = (float) $value->valor / 100;
                        $enfermaria_mesma_via['base'] = (float) $value->valor_base / 100;
                    } else {
                        $enfermaria_via_diferente['maior'] = (float) $value->valor / 100;
                        $enfermaria_via_diferente['base'] = (float) $value->valor_base / 100;
                    }
                } else {
                    if ($value->mesma_via == 't') {
                        $apartamento_mesma_via['maior'] = (float) $value->valor / 100;
                        $apartamento_mesma_via['base'] = (float) $value->valor_base / 100;
                    } else {
                        $apartamento_via_diferente['maior'] = (float) $value->valor / 100;
                        $apartamento_via_diferente['base'] = (float) $value->valor_base / 100;
                    }
                }
            }

            $valMedico = 0;
//            var_dump($procedimentos); die;
            foreach ($equipe as $value) {
                $i = 0;

                foreach ($procedimentos as $item) {
                    $valor = (float) $item->valor;
                    $valProcedimento = ( $item->horario_especial == 't' ) ? ($valor) + ($valor * $horario_especial) : $valor;

                    if ($solicitacao[0]->leito == 'ENFERMARIA') {// LEITO DE ENFERMARIA
                        if ($item->via == 'D') {// VIA DIFERENTE
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $enfermaria_via_diferente['maior'];
                            } else {
                                $valMedicoProc = ($valProcedimento * $enfermaria_via_diferente['base']);
                            }
                        } elseif ($item->via == 'M') {// MESMA VIA
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $enfermaria_mesma_via['maior'];
                            } else {
                                $valMedicoProc = ($valProcedimento * $enfermaria_mesma_via['base']);
                            }
                        }
                    } else { //APARTAMENTO
                        if ($item->via == 'D') {// VIA DIFERENTE
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $apartamento_via_diferente['maior'];
                            } else {
                                $valMedicoProc = ($valProcedimento * $apartamento_via_diferente['base']);
                            }
                        } elseif ($item->via == 'M') {// MESMA VIA
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $apartamento_mesma_via['maior'];
                            } else {
                                $valMedicoProc = $valProcedimento * $apartamento_mesma_via['base'];
                            }
                        }
                    }

                    //VALOR DO CIRURGIAO/ANESTESISTA
                    $valMedico = $valMedicoProc;

                    if ((int) $value->funcao != 0) {
                        $this->db->select('valor');
                        $this->db->from('tb_centrocirurgico_percentual_funcao');
                        $this->db->where("funcao", $value->funcao);
                        $query = $this->db->get();
                        $return2 = $query->result();

                        $this->db->select('valor');
                        $this->db->from('tb_centrocirurgico_percentual_funcao');
                        $this->db->where("funcao", 0);
                        $query_0 = $this->db->get();
                        $return_0 = $query_0->result();
                        //DEFININDO OS VALORES
                        $val_cirurgiao = number_format($valMedico * ($return_0[0]->valor / 100), 2, '.', '');
                        $val = number_format($val_cirurgiao * ($return2[0]->valor / 100), 2, '.', '');
                    } else {
                        $this->db->select('valor');
                        $this->db->from('tb_centrocirurgico_percentual_funcao');
                        $this->db->where("funcao", $value->funcao);
                        $query = $this->db->get();
                        $return2 = $query->result();
                        $val = number_format($valMedico * ($return2[0]->valor / 100), 2, '.', '');
                    }
                    
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    if ($item->equipe_particular == 't') {
                        $this->db->set('particular', 't');
                    }
                    $this->db->set('operador_responsavel', $value->operador_responsavel);
                    $this->db->set('solicitacao_orcamento_convenio_id', $orcamento_convenio_id);
                    $this->db->set('solicitacao_cirurgia_procedimento_id', $item->solicitacao_cirurgia_procedimento_id);
                    $this->db->set('valor', $val);
                    $this->db->set('funcao', $value->funcao);

                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_solicitacao_orcamento_convenio_equipe');



                    $i++;
                }
            }
            
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarsolicitacaorcamentoitens($orcamento_id) {

        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            // Trazendo os procedimentos
            $this->db->select(' scp.horario_especial,
                                scp.valor,
                                scp.via,
                                c.dinheiro,
                                scp.solicitacao_cirurgia_procedimento_id');
            $this->db->from('tb_solicitacao_cirurgia_procedimento scp');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = scp.procedimento_tuss_id', 'left');
            $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
            $this->db->where("scp.ativo", 't');
//            $this->db->where("c.dinheiro", 't');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $this->db->orderby('valor DESC');
            $procedimentos = $this->db->get()->result();

//            var_dump($procedimentos);
//            die;
//            echo "<pre>";
            // Trazendo a lista com todos os integrantes da equipe cirurgica
            $this->db->select('leito');
            $this->db->from('tb_solicitacao_cirurgia');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $solicitacao = $this->db->get()->result();

            // Trazendo a lista com todos os integrantes da equipe cirurgica
            $this->db->select('funcao, gp.descricao, operador_responsavel');
            $this->db->from('tb_equipe_cirurgia_operadores eco');
            $this->db->join('tb_grau_participacao gp', 'gp.codigo = eco.funcao', 'left');
            $this->db->where('eco.ativo', 't');
            $this->db->where('gp.ativo', 't');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $equipe = $this->db->get()->result();

            // Trazendo o valor dos percentuais configurados
            $this->db->select(' leito_enfermaria,
                                leito_apartamento,
                                mesma_via,
                                via_diferente,
                                horario_especial,
                                valor,
                                valor_base');
            $this->db->from('tb_centrocirurgico_percentual_outros cpo');
            $this->db->where("ativo", 't');
            $query = $this->db->get();
            $return = $query->result();

            foreach ($return as $value) {

                if ($value->horario_especial == 't') {
                    $horario_especial = ($value->valor / 100);
                    continue;
                }

                if ($value->leito_enfermaria == 't') {
                    if ($value->mesma_via == 't') {
                        $enfermaria_mesma_via['maior'] = (float) $value->valor / 100;
                        $enfermaria_mesma_via['base'] = (float) $value->valor_base / 100;
                    } else {
                        $enfermaria_via_diferente['maior'] = (float) $value->valor / 100;
                        $enfermaria_via_diferente['base'] = (float) $value->valor_base / 100;
                    }
                } else {
                    if ($value->mesma_via == 't') {
                        $apartamento_mesma_via['maior'] = (float) $value->valor / 100;
                        $apartamento_mesma_via['base'] = (float) $value->valor_base / 100;
                    } else {
                        $apartamento_via_diferente['maior'] = (float) $value->valor / 100;
                        $apartamento_via_diferente['base'] = (float) $value->valor_base / 100;
                    }
                }
            }

            $valMedico = 0;

            foreach ($equipe as $value) {
                $i = 0;

                foreach ($procedimentos as $item) {
                    $valor = (float) $item->valor;
                    $valProcedimento = ( $item->horario_especial == 't' ) ? ($valor) + ($valor * $horario_especial) : $valor;

                    if ($solicitacao[0]->leito == 'ENFERMARIA') {// LEITO DE ENFERMARIA
                        if ($item->via == 'D') {// VIA DIFERENTE
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $enfermaria_via_diferente['maior'];
                            } else {
                                $valMedicoProc = ($valProcedimento * $enfermaria_via_diferente['base']);
                            }
                        } elseif ($item->via == 'M') {// MESMA VIA
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $enfermaria_mesma_via['maior'];
                            } else {
                                $valMedicoProc = ($valProcedimento * $enfermaria_mesma_via['base']);
                            }
                        }
                    } else { //APARTAMENTO
                        if ($item->via == 'D') {// VIA DIFERENTE
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $apartamento_via_diferente['maior'];
                            } else {
                                $valMedicoProc = ($valProcedimento * $apartamento_via_diferente['base']);
                            }
                        } elseif ($item->via == 'M') {// MESMA VIA
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $apartamento_mesma_via['maior'];
                            } else {
                                $valMedicoProc = $valProcedimento * $apartamento_mesma_via['base'];
                            }
                        }
                    }

                    //VALOR DO CIRURGIAO/ANESTESISTA
                    $valMedico = $valMedicoProc;
                    if ($item->dinheiro == 't') {

                        if ((int) $value->funcao != 0) {
                            $this->db->select('valor');
                            $this->db->from('tb_centrocirurgico_percentual_funcao');
                            $this->db->where("funcao", $value->funcao);
                            $query = $this->db->get();
                            $return2 = $query->result();

                            $this->db->select('valor');
                            $this->db->from('tb_centrocirurgico_percentual_funcao');
                            $this->db->where("funcao", 0);
                            $query_0 = $this->db->get();
                            $return_0 = $query_0->result();
                            //DEFININDO OS VALORES
                            $val_cirurgiao = number_format($valMedico * ($return_0[0]->valor / 100), 2, '.', '');
                            $val = number_format($val_cirurgiao * ($return2[0]->valor / 100), 2, '.', '');
                        } else {
                            $this->db->select('valor');
                            $this->db->from('tb_centrocirurgico_percentual_funcao');
                            $this->db->where("funcao", $value->funcao);
                            $query = $this->db->get();
                            $return2 = $query->result();
                            $val = number_format($valMedico * ($return2[0]->valor / 100), 2, '.', '');
                        }
//                    var_dump($val);
//                    die;
                        $horario = date("Y-m-d H:i:s");
                        $operador_id = $this->session->userdata('operador_id');

                        $this->db->set('operador_responsavel', $value->operador_responsavel);
                        $this->db->set('solicitacao_orcamento_id', $orcamento_id);
                        $this->db->set('solicitacao_cirurgia_procedimento_id', $item->solicitacao_cirurgia_procedimento_id);
                        $this->db->set('valor', $val);
                        $this->db->set('funcao', $value->funcao);

                        $this->db->set('data_cadastro', $horario);
                        $this->db->set('operador_cadastro', $operador_id);
                        $this->db->insert('tb_solicitacao_orcamento_equipe');
                    }
                    $i++;
                }
            }
//            die;
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravareditarprocedimentosolicitacaocirurgica($guia_id, $solicitacao_id) {

        try {

            $this->db->set('guia_id', $guia_id);
            $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
            $this->db->update('tb_solicitacao_cirurgia');

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->select('ag.via, ag.leito');
            $this->db->from('tb_ambulatorio_guia ag');
            $this->db->where("ag.ambulatorio_guia_id", $guia_id);
            $query = $this->db->get()->result();
            $guia = $query[0];

            // Trazendo a lista com todos os integrantes da equipe cirurgica
            $this->db->select('funcao, gp.codigo, operador_responsavel');
            $this->db->from('tb_equipe_cirurgia_operadores eco');
            $this->db->join('tb_grau_participacao gp', 'gp.codigo = eco.funcao', 'left');
            $this->db->where('eco.ativo', 't');
            $this->db->where('gp.ativo', 't');
            $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
            $equipe = $this->db->get()->result();

            // Trazendo o valor dos percentuais configurados
            $this->db->select(' leito_enfermaria,
                                leito_apartamento,
                                mesma_via,
                                via_diferente,
                                horario_especial,
                                valor,
                                valor_base');
            $this->db->from('tb_centrocirurgico_percentual_outros cpo');
            $this->db->where("ativo", 't');
            $query = $this->db->get();
            $return = $query->result();
            foreach ($return as $value) {

                if ($value->horario_especial == 't') {
                    $horario_especial = ($value->valor / 100);
                    continue;
                }

                if ($value->leito_enfermaria == 't') {
                    if ($value->mesma_via == 't') {
                        $enfermaria_mesma_via['maior'] = (float) $value->valor / 100;
                        $enfermaria_mesma_via['base'] = (float) $value->valor_base / 100;
                    } else {
                        $enfermaria_via_diferente['maior'] = (float) $value->valor / 100;
                        $enfermaria_via_diferente['base'] = (float) $value->valor_base / 100;
                    }
                } else {
                    if ($value->mesma_via == 't') {
                        $apartamento_mesma_via['maior'] = (float) $value->valor / 100;
                        $apartamento_mesma_via['base'] = (float) $value->valor_base / 100;
                    } else {
                        $apartamento_via_diferente['maior'] = (float) $value->valor / 100;
                        $apartamento_via_diferente['base'] = (float) $value->valor_base / 100;
                    }
                }
            }

            $this->db->select('a.agenda_exames_id,
                                a.data,
                                a.guia_id,
                                a.tipo,
                                a.horario_especial,
                                a.procedimento_tuss_id,
                                a.valor_total,
                                scp.via,
                                scp.equipe_particular,
                                pt.nome as procedimento,
                                c.nome as convenio,
                                a.observacoes');
            $this->db->from('tb_agenda_exames a');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
            $this->db->join('tb_solicitacao_cirurgia_procedimento scp', 'scp.agenda_exames_id = a.agenda_exames_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
            $this->db->where("a.guia_id", $guia_id);
            $this->db->orderby("a.valor_total DESC");
            $procedimentos = $this->db->get()->result();
//            var_dump($procedimentos); die;
            $valMedico = 0;
            foreach ($equipe as $item) {
                for ($i = 0; $i < count($procedimentos); $i++) {
                    $valor = (float) $procedimentos[$i]->valor_total;
                    $valProcedimento = ($procedimentos[$i]->horario_especial == 't') ? ($valor) + ($valor * $horario_especial) : $valor;

                    if ($guia->leito == 'ENFERMARIA') {// LEITO DE ENFERMARIA
                        if ($procedimentos[$i]->via == 'D') {// VIA DIFERENTE
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $enfermaria_via_diferente['maior'];
                            } else {
                                $valMedicoProc = ($valProcedimento * $enfermaria_via_diferente['base']);
                            }
                        } elseif ($procedimentos[$i]->via == 'M') {// MESMA VIA
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $enfermaria_mesma_via['maior'];
                            } else {
                                $valMedicoProc = ($valProcedimento * $enfermaria_mesma_via['base']);
                            }
                        }
                    } else { //APARTAMENTO
                        if ($procedimentos[$i]->via == 'D') {// VIA DIFERENTE
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $apartamento_via_diferente['maior'];
                            } else {
                                $valMedicoProc = ($valProcedimento * $apartamento_via_diferente['base']);
                            }
                        } elseif ($procedimentos[$i]->via == 'M') {// MESMA VIA
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $apartamento_mesma_via['maior'];
                            } else {
                                $valMedicoProc = $valProcedimento * $apartamento_mesma_via['base'];
                            }
                        }
                    }

                    //VALOR DO CIRURGIAO/ANESTESISTA
                    $valMedico = $valMedicoProc;

                    if ((int) $item->codigo != 0) {
                        $this->db->select('valor');
                        $this->db->from('tb_centrocirurgico_percentual_funcao');
                        $this->db->where("funcao", $item->codigo);
                        $query = $this->db->get();
                        $return2 = $query->result();

                        $this->db->select('valor');
                        $this->db->from('tb_centrocirurgico_percentual_funcao');
                        $this->db->where("funcao", 0);
                        $query = $this->db->get();
                        $return_0 = $query->result();

                        //DEFININDO OS VALORES
                        $val_cirurgiao = number_format($valMedico * ($return_0[0]->valor / 100), 2, '.', '');
                        $val = number_format($val_cirurgiao * ($return2[0]->valor / 100), 2, '.', '');
                    } else {
                        $this->db->select('valor');
                        $this->db->from('tb_centrocirurgico_percentual_funcao');
                        $this->db->where("funcao", (int) $item->codigo);
                        $query = $this->db->get();
                        $return2 = $query->result();
                        $val = number_format($valMedico * ($return2[0]->valor / 100), 2, '.', '');
                    }

                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');

                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->set('operador_responsavel', $item->operador_responsavel);
                    $this->db->set('agenda_exames_id', $procedimentos[$i]->agenda_exames_id);
                    $this->db->set('guia_id', $procedimentos[$i]->guia_id);
                    $this->db->set('valor', $val);
                    $this->db->set('equipe_particular', $procedimentos[$i]->equipe_particular);
                    $this->db->set('funcao', $item->codigo);
                    $this->db->insert('tb_agenda_exame_equipe');

//                    $sql = "UPDATE ponto.tb_agenda_exames
//                            SET valor_total = valor_total + $val, valor = valor + $val 
//                            WHERE agenda_exames_id = {$procedimentos[$i]->agenda_exames_id};";
//                    $this->db->query($sql);
                }
            }

            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarprocedimentosolicitacaocirurgica($guia_id) {

        try {

            $this->db->set('guia_id', $guia_id);
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $this->db->update('tb_solicitacao_cirurgia');

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->select('ag.via, ag.leito');
            $this->db->from('tb_ambulatorio_guia ag');
            $this->db->where("ag.ambulatorio_guia_id", $guia_id);
            $query = $this->db->get()->result();
            $guia = $query[0];

            // Trazendo a lista com todos os integrantes da equipe cirurgica
            $this->db->select('funcao, gp.codigo, operador_responsavel');
            $this->db->from('tb_equipe_cirurgia_operadores eco');
            $this->db->join('tb_grau_participacao gp', 'gp.codigo = eco.funcao', 'left');
            $this->db->where('eco.ativo', 't');
            $this->db->where('gp.ativo', 't');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $equipe = $this->db->get()->result();

            // Trazendo o valor dos percentuais configurados
            $this->db->select(' leito_enfermaria,
                                leito_apartamento,
                                mesma_via,
                                via_diferente,
                                horario_especial,
                                valor,
                                valor_base');
            $this->db->from('tb_centrocirurgico_percentual_outros cpo');
            $this->db->where("ativo", 't');
            $query = $this->db->get();
            $return = $query->result();
            foreach ($return as $value) {

                if ($value->horario_especial == 't') {
                    $horario_especial = ($value->valor / 100);
                    continue;
                }

                if ($value->leito_enfermaria == 't') {
                    if ($value->mesma_via == 't') {
                        $enfermaria_mesma_via['maior'] = (float) $value->valor / 100;
                        $enfermaria_mesma_via['base'] = (float) $value->valor_base / 100;
                    } else {
                        $enfermaria_via_diferente['maior'] = (float) $value->valor / 100;
                        $enfermaria_via_diferente['base'] = (float) $value->valor_base / 100;
                    }
                } else {
                    if ($value->mesma_via == 't') {
                        $apartamento_mesma_via['maior'] = (float) $value->valor / 100;
                        $apartamento_mesma_via['base'] = (float) $value->valor_base / 100;
                    } else {
                        $apartamento_via_diferente['maior'] = (float) $value->valor / 100;
                        $apartamento_via_diferente['base'] = (float) $value->valor_base / 100;
                    }
                }
            }

            $this->db->select('a.agenda_exames_id,
                                a.data,
                                a.guia_id,
                                a.tipo,
                                a.via,
                                a.horario_especial,
                                a.procedimento_tuss_id,
                                a.valor_total,
                                spc.equipe_particular,
                                pt.nome as procedimento,
                                c.nome as convenio,
                                a.observacoes');
            $this->db->from('tb_agenda_exames a');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
            $this->db->join('tb_solicitacao_cirurgia_procedimento spc', 'spc.agenda_exames_id = a.agenda_exames_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
            $this->db->where("a.guia_id", $guia_id);
            $this->db->orderby("a.valor_total DESC");
            $procedimentos = $this->db->get()->result();

            $valMedico = 0;
            foreach ($equipe as $item) {
                for ($i = 0; $i < count($procedimentos); $i++) {
                    $valor = (float) $procedimentos[$i]->valor_total;
                    $valProcedimento = ($procedimentos[$i]->horario_especial == 't') ? ($valor) + ($valor * $horario_especial) : $valor;

                    if ($guia->leito == 'ENFERMARIA') {// LEITO DE ENFERMARIA
                        if ($procedimentos[$i]->via == 'D') {// VIA DIFERENTE
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $enfermaria_via_diferente['maior'];
                            } else {
                                $valMedicoProc = ($valProcedimento * $enfermaria_via_diferente['base']);
                            }
                        } elseif ($procedimentos[$i]->via == 'M') {// MESMA VIA
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $enfermaria_mesma_via['maior'];
                            } else {
                                $valMedicoProc = ($valProcedimento * $enfermaria_mesma_via['base']);
                            }
                        }
                    } else { //APARTAMENTO
                        if ($procedimentos[$i]->via == 'D') {// VIA DIFERENTE
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $apartamento_via_diferente['maior'];
                            } else {
                                $valMedicoProc = ($valProcedimento * $apartamento_via_diferente['base']);
                            }
                        } elseif ($procedimentos[$i]->via == 'M') {// MESMA VIA
                            if ($i == 0) {
                                $valMedicoProc = $valProcedimento * $apartamento_mesma_via['maior'];
                            } else {
                                $valMedicoProc = $valProcedimento * $apartamento_mesma_via['base'];
                            }
                        }
                    }

                    //VALOR DO CIRURGIAO/ANESTESISTA
                    $valMedico = $valMedicoProc;

                    if ((int) $item->codigo != 0) {
                        $this->db->select('valor');
                        $this->db->from('tb_centrocirurgico_percentual_funcao');
                        $this->db->where("funcao", $item->codigo);
                        $query = $this->db->get();
                        $return2 = $query->result();

                        $this->db->select('valor');
                        $this->db->from('tb_centrocirurgico_percentual_funcao');
                        $this->db->where("funcao", 0);
                        $query = $this->db->get();
                        $return_0 = $query->result();

                        //DEFININDO OS VALORES
                        $val_cirurgiao = number_format($valMedico * ($return_0[0]->valor / 100), 2, '.', '');
                        $val = number_format($val_cirurgiao * ($return2[0]->valor / 100), 2, '.', '');
                    } else {
                        $this->db->select('valor');
                        $this->db->from('tb_centrocirurgico_percentual_funcao');
                        $this->db->where("funcao", (int) $item->codigo);
                        $query = $this->db->get();
                        $return2 = $query->result();
                        $val = number_format($valMedico * ($return2[0]->valor / 100), 2, '.', '');
                    }

                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    if ($procedimentos[$i]->equipe_particular == 't') {
                        $this->db->set('equipe_particular', 't');
                    }
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->set('operador_responsavel', $item->operador_responsavel);
                    $this->db->set('agenda_exames_id', $procedimentos[$i]->agenda_exames_id);
                    $this->db->set('guia_id', $procedimentos[$i]->guia_id);
                    $this->db->set('valor', $val);
                    $this->db->set('funcao', $item->codigo);
                    $this->db->insert('tb_agenda_exame_equipe');

//                    $sql = "UPDATE ponto.tb_agenda_exames
//                            SET valor_total = valor_total + $val, valor = valor + $val 
//                            WHERE agenda_exames_id = {$procedimentos[$i]->agenda_exames_id};";
//                    $this->db->query($sql);
                }
            }

            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravareditarcirurgia() {

        try {
            // Trazendo a lista com todos os integrantes da equipe cirurgica
            $this->db->select('leito, convenio, paciente_id, guia_id');
            $this->db->from('tb_solicitacao_cirurgia');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $solicitacao = $this->db->get()->result();

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');


            $this->db->set('via', $_POST['via']);
            $this->db->set('data_prevista', $_POST['txtdata']);
            $this->db->set('hora_prevista', date("H:i:s", strtotime($_POST['hora'])));
            $this->db->set('hora_prevista_fim', date("H:i:s", strtotime($_POST['hora_fim'])));
//            $this->db->set('situacao', 'FATURAMENTO_PENDENTE');
//            $this->db->set('situacao_convenio', 'FATURAMENTO_PENDENTE');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $this->db->update('tb_solicitacao_cirurgia');

            $this->db->set('inicio', $_POST['hora']);
            $this->db->set('fim', $_POST['hora_fim']);
            $this->db->set('data', $_POST['txtdata']);
            $this->db->where('guia_id', $solicitacao[0]->guia_id);
            $this->db->update('tb_agenda_exames');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluirentradasagendaexames($guia_id) {

        try {

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $ambulatorio_guia_id = $guia_id;
            $this->db->where('guia_id', $ambulatorio_guia_id);
            $this->db->delete('tb_agenda_exames');

            $this->db->set('ativo', 'f');
            $this->db->where('guia_id', $ambulatorio_guia_id);
            $this->db->update('tb_agenda_exame_equipe');


            return $ambulatorio_guia_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarguiaeditarprocedimentoscirurgia($guia_id, $solicitacao_id) {

        try {

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            // Trazendo os procedimentos
            $this->db->select(' horario_especial,
                                valor,
                                quantidade,
                                via,
                                equipe_particular,
                                desconto,
                                solicitacao_cirurgia_procedimento_id,
                                procedimento_tuss_id');
            $this->db->from('tb_solicitacao_cirurgia_procedimento');
            $this->db->where("ativo", 't');
            $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
            $this->db->orderby('valor DESC');
            $procedimentos = $this->db->get()->result();

            // Trazendo a lista com todos os integrantes da equipe cirurgica
            $this->db->select('leito, convenio, paciente_id');
            $this->db->from('tb_solicitacao_cirurgia');
            $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
            $solicitacao = $this->db->get()->result();

            $ambulatorio_guia_id = $guia_id;

            foreach ($procedimentos as $item) {

                if ($item->quantidade > 0) {
                    $quantidade = $item->quantidade;
                } else {
                    $quantidade = 1;
                }
                $valor_total = ( $item->valor - ($item->valor * $item->desconto) / 100);

                $this->db->set('operador_autorizacao', $operador_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'CIRURGICO');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 't');
                $this->db->set('valor', $valor_total / $quantidade);
                $this->db->set('via', $item->via);
                $this->db->set('valor_total', $valor_total);

//                if ($_POST['formapamento'] != '') {
//                    $this->db->set('valor1', $valor_total);
//                    $this->db->set('forma_pagamento', $_POST['formapamento']);
//                    $this->db->set('operador_faturamento', $operador_id);
//                    $this->db->set('data_faturamento', $horario);
//                }

                $this->db->set('situacao', 'OK');
                $this->db->set('quantidade', $quantidade);
                $this->db->set('data', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata']))));
                $this->db->set('data_faturar', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata']))));
                $this->db->set('inicio', $_POST['hora']);
                $this->db->set('fim', $_POST['hora_fim']);
                $this->db->set('procedimento_tuss_id', $item->procedimento_tuss_id);
                $this->db->set('guia_id', $ambulatorio_guia_id);

                if ($item->horario_especial == 't') {
                    $this->db->set('horario_especial', 't');
                } else {
                    $this->db->set('horario_especial', 'f');
                }

                if ($item->equipe_particular == 't') {
                    $this->db->set('equipe_particular', 't');
                } else {
                    $this->db->set('equipe_particular', 'f');
                }

                $this->db->set('data_autorizacao', $horario);
                $this->db->set('paciente_id', $solicitacao[0]->paciente_id);

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda_exames');
                $agenda_exames_id = $this->db->insert_id();

//                $this->db->set('valor', $agenda_exames_id);
                $this->db->set('agenda_exames_id', $agenda_exames_id);
                $this->db->where('solicitacao_cirurgia_procedimento_id', $item->solicitacao_cirurgia_procedimento_id);
                $this->db->update('tb_solicitacao_cirurgia_procedimento');
            }

            return $ambulatorio_guia_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarguiasolicitacaocirurgica() {

        try {

            $horario = date("Y-m-d H:i:s");
            $data = date("Y-m-d");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            // Trazendo os procedimentos
            $this->db->select(' horario_especial,
                                valor,
                                equipe_particular,
                                quantidade,
                                via,
                                desconto,
                                solicitacao_cirurgia_procedimento_id,
                                procedimento_tuss_id');
            $this->db->from('tb_solicitacao_cirurgia_procedimento');
            $this->db->where("ativo", 't');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $this->db->orderby('valor DESC');
            $procedimentos = $this->db->get()->result();
//            var_dump($procedimentos);
//            die;
            // Trazendo a lista com todos os integrantes da equipe cirurgica
            $this->db->select('leito, convenio, paciente_id');
            $this->db->from('tb_solicitacao_cirurgia');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $solicitacao = $this->db->get()->result();

            /* GRAVANDO OS PROCEDIMENTOS NA GUIA */
//            $this->db->set('via', $_POST['via']);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('equipe', 't');
            $this->db->set('tipo', 'CIRURGICO');
            $this->db->set('data_criacao', $data);
            $this->db->set('leito', $solicitacao[0]->leito);
            $this->db->set('convenio_id', $solicitacao[0]->convenio);
            $this->db->set('paciente_id', $solicitacao[0]->paciente_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_guia');
            $ambulatorio_guia_id = $this->db->insert_id();

            foreach ($procedimentos as $item) {
                if ($item->quantidade > 0) {
                    $quantidade = $item->quantidade;
                } else {
                    $quantidade = 1;
                }
                $valor_total = ( $item->valor - ($item->valor * $item->desconto) / 100);

                $this->db->set('operador_autorizacao', $operador_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('tipo', 'CIRURGICO');
                $this->db->set('ativo', 'f');
                $this->db->set('cancelada', 'f');
                $this->db->set('confirmado', 't');
                $this->db->set('valor', $valor_total / $quantidade);
                $this->db->set('via', $item->via);
                $this->db->set('valor_total', $valor_total);

//                if ($_POST['formapamento'] != '') {
//                    $this->db->set('valor1', $valor_total);
//                    $this->db->set('forma_pagamento', $_POST['formapamento']);
//                    $this->db->set('operador_faturamento', $operador_id);
//                    $this->db->set('data_faturamento', $horario);
//                }

                $this->db->set('situacao', 'OK');
                $this->db->set('quantidade', $quantidade);
                $this->db->set('data', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata']))));
                $this->db->set('data_faturar', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata']))));
                $this->db->set('inicio', $_POST['hora']);
                $this->db->set('fim', $_POST['hora_fim']);
                $this->db->set('procedimento_tuss_id', $item->procedimento_tuss_id);
                $this->db->set('guia_id', $ambulatorio_guia_id);

                if ($item->horario_especial == 't') {
                    $this->db->set('horario_especial', 't');
                } else {
                    $this->db->set('horario_especial', 'f');
                }

                if ($item->equipe_particular == 't') {
                    $this->db->set('equipe_particular', 't');
                } else {
                    $this->db->set('equipe_particular', 'f');
                }

                $this->db->set('data_autorizacao', $horario);
                $this->db->set('paciente_id', $solicitacao[0]->paciente_id);

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda_exames');
                $agenda_exames_id = $this->db->insert_id();

//                $this->db->set('valor', $agenda_exames_id);
                $this->db->set('agenda_exames_id', $agenda_exames_id);
                $this->db->where('solicitacao_cirurgia_procedimento_id', $item->solicitacao_cirurgia_procedimento_id);
                $this->db->update('tb_solicitacao_cirurgia_procedimento');
            }

            return $ambulatorio_guia_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function autorizarsolicitacaocirurgica() {
//        echo '<pre>';
//        var_dump($_POST);
//        die;
        try {
            $i = 0;
            foreach ($_POST['procedimento_convenio_id'] as $item) {
//                $valor = $_POST['valor_total'][$i];
                $valor_total = (float) $_POST['valor_total'][$i];
                $quantidade = (int) $_POST['quantidade'][$i];
                $valor_unitario = (float) $valor_total / $quantidade;
                $desconto = $_POST['desconto'];
                $cirurgia_procedimento_id = $_POST['cirurgia_procedimento_id'][$i];
                $horEspecial = @$_POST['horEspecial'][$i];

                $this->db->set('quantidade', $quantidade);
                $this->db->set('horario_especial', $horEspecial);
                $this->db->set('desconto', $desconto);
                $this->db->set('valor', $valor_total);
                $this->db->set('valor_unitario', $valor_unitario);
                $this->db->set('via', $_POST['via'][$i]);
                $this->db->where('solicitacao_cirurgia_procedimento_id', $cirurgia_procedimento_id);
                $this->db->update('tb_solicitacao_cirurgia_procedimento');


                $i++;
            }

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('autorizado', 't');
            $this->db->set('data_autorizacao', date("Y-m-d"));
            $this->db->set('operador_autorizacao', $operador_id);
//            $this->db->set('via', $_POST['via']);
            $this->db->set('data_prevista', $_POST['txtdata']);
            $this->db->set('hora_prevista', $_POST['hora']);
            $this->db->set('hora_prevista_fim', $_POST['hora_fim']);
            $this->db->set('situacao', 'FATURAMENTO_PENDENTE');
            $this->db->set('situacao_convenio', 'FATURAMENTO_PENDENTE');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $this->db->update('tb_solicitacao_cirurgia');

            $_POST['desconto'] = (float) $_POST['desconto'];

            return $_POST['txtsolcitacao_id'];
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarsolicitacaorcamentoconvenio() {

        try {
            $this->db->select('solicitacao_orcamento_convenio_id');
            $this->db->from('tb_solicitacao_orcamento_convenio');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $this->db->where('ativo', 't');
            $solicitacao = $this->db->get()->result();
            @$solicitacao_orcamento_id = $solicitacao[0]->solicitacao_orcamento_convenio_id;

//            var_dump($solicitacao_orcamento_id);
//            die;
            $this->db->set('ativo', 'f');
            $this->db->where('solicitacao_orcamento_convenio_id', @$solicitacao_orcamento_id);
            $this->db->update('tb_solicitacao_orcamento_convenio_equipe');

            $this->db->set('ativo', 'f');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $this->db->update('tb_solicitacao_orcamento_convenio');
//            
//            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
//            $this->db->delete('tb_solicitacao_cirurgia_procedimento');
//            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
//            $this->db->delete('tb_solicitacao_cirurgia_procedimento');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

//            $this->db->set('via', $_POST['via']);
//            $this->db->set('situacao', 'ORCAMENTO_COMPLETO');
            $this->db->set('situacao_convenio', 'GUIA_FEITA');
//            $this->db->set('orcamentoconvenio_completo', 't');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $this->db->update('tb_solicitacao_cirurgia');

            $_POST['desconto'] = (float) $_POST['desconto'];


            $this->db->set('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_solicitacao_orcamento_convenio');
            $orcamentoconvenio_id = $this->db->insert_id();



//            var_dump($_POST); die;
            foreach ($_POST['cirurgia_procedimento_id'] as $key => $item) {
                $valor = (float) $_POST['valor'][$key];
                $valor_total = (float) $_POST['valor_total'][$key];

                $quantidade = (int) $_POST['quantidade'][$key];
                $valor_unitario = (float) $valor_total / $quantidade;
                if (@$_POST['equipe_particular'][$key] == 'on') {
                    $this->db->set('equipe_particular', 't');
                } else {
                    $this->db->set('equipe_particular', 'f');
                }

                $this->db->set('horario_especial', (isset($_POST['horEspecial'][$key]) ? 't' : 'f'));
                $this->db->set('quantidade', $quantidade);
                $this->db->set('valor', $valor_total);
                $this->db->set('valor_unitario', $valor_unitario);
                $this->db->set('via', $_POST['via'][$key]);
                $this->db->where('solicitacao_cirurgia_procedimento_id', $_POST['cirurgia_procedimento_id'][$key]);
                $this->db->update('tb_solicitacao_cirurgia_procedimento');
            }

            return $orcamentoconvenio_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarsolicitacaorcamento() {

        try {

            $this->db->select('solicitacao_orcamento_id');
            $this->db->from('tb_solicitacao_orcamento');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $solicitacao = $this->db->get()->result();
            @$solicitacao_orcamento_id = $solicitacao[0]->solicitacao_orcamento_id;



            $this->db->where('solicitacao_orcamento_id', @$solicitacao_orcamento_id);
            $this->db->delete('tb_solicitacao_orcamento');

            $this->db->set('ativo', 'f');
            $this->db->where('solicitacao_orcamento_id', @$solicitacao_orcamento_id);
            $this->db->update('tb_solicitacao_orcamento_equipe');
//            var_dump($solicitacao_orcamento_id);
//            die;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

//            $this->db->set('via', $_POST['via']);
            $this->db->set('situacao', 'ORCAMENTO_COMPLETO');
//            $this->db->set('situacao_convenio', 'ORCAMENTO_COMPLETO');
            $this->db->set('orcamento_completo', 't');
            $this->db->where('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $this->db->update('tb_solicitacao_cirurgia');

            $_POST['desconto'] = (float) $_POST['desconto'];

            $this->db->set('solicitacao_cirurgia_id', $_POST['txtsolcitacao_id']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_solicitacao_orcamento');
            $orcamento_id = $this->db->insert_id();

            $this->db->where('solicitacao_orcamento_id', $orcamento_id);
            $this->db->delete('tb_solicitacao_orcamento_equipe');

//            var_dump($_POST);
//            die;
            foreach ($_POST['cirurgia_procedimento_id'] as $key => $item) {
                $valor = (float) $_POST['valor'][$key];
                $valor_total = (float) $_POST['valor_total'][$key];

                $quantidade = (int) $_POST['quantidade'][$key];
                $valor_unitario = (float) $valor_total / $quantidade;

                $this->db->set('horario_especial', (isset($_POST['horEspecial'][$key]) ? 't' : 'f'));
                $this->db->set('quantidade', $quantidade);
                $this->db->set('valor', $valor_total);
                $this->db->set('valor_unitario', $valor_unitario);
                $this->db->set('via', $_POST['via'][$key]);
                $this->db->where('solicitacao_cirurgia_procedimento_id', $_POST['cirurgia_procedimento_id'][$key]);
                $this->db->update('tb_solicitacao_cirurgia_procedimento');
            }
            return $orcamento_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarequipe() {

        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('nome', $_POST['nome']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_equipe_cirurgia');
            $equipe_id = $this->db->insert_id();
            if (trim($erro) != "") { // erro de banco
                return -1;
            }

            return $equipe_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

}

?>
