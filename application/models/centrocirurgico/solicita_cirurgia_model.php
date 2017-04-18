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

    function listarprocedimentosagrupador($agrupador) {
        $this->db->select('procedimento_tuss_id as procedimento_id');
        $this->db->from('tb_procedimentos_agrupados');
        $this->db->where('ativo', 't');
        $this->db->where('agrupador_id', $agrupador);
        $return = $this->db->get();
        return $return->result();
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


//        $this->db->select(' pt.procedimento_tuss_id,
//                            pt.descricao');
//        $this->db->from('tb_procedimento_tuss pt');
//        $this->db->where('pt.ativo', 't');
//        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
//        $this->db->where('ag.tipo', 'EXAME');
//
//        $return = $this->db->get();
//        return $return->result();
//        
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

    function carregarsolicitacaoagrupador() {


        $this->db->select('an.agrupador_id, an.nome');
        $this->db->from('tb_agrupador_procedimento_nome an');
        $this->db->where('an.ativo', 't');

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

    function listarsolicitacaosprocedimentos($solicitacao_id) {
        $this->db->select('scp.solicitacao_cirurgia_procedimento_id as solicitacao_procedimento_id,
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

    function listarprocedimentos_orcamentados($solicitacao_id) {
        $this->db->select('pt.nome as procedimento,
                           pt.procedimento_tuss_id,
                           pt.codigo,
                           fc.nome as grau_participacao,
                           o.nome as medico,
                           co.valor,
                           co.observacao,
                           co.solicitacao_cirurgia_orcamento_id');
        $this->db->from('tb_solicitacao_cirurgia_orcamento co');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = co.procedimento_tuss_id', 'left');
        $this->db->join('tb_funcoes_cirurgia fc', 'fc.funcao_cirurgia_id = co.grau_participacao', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = co.operador_responsavel', 'left');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->where('co.ativo', 't');

        $return = $this->db->get();
        return $return->result();
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
        $this->db->join('tb_grau_participacao gp', 'gp.grau_participacao_id = ec.funcao', 'left');
        $this->db->where('ec.solicitacao_cirurgia_id', $solicitacaocirurgia_id);
        $this->db->where('ec.ativo', 't');

        $return = $this->db->get();
        return $return->result();
    }

    function gravarnovasolicitacao() {

        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            //mapeando banco
            $this->db->set('paciente_id', $_POST['txtNomeid']);
//            $this->db->set('procedimento_id', $_POST['procedimentoID']);
//            $this->db->set('data_prevista', $_POST['txtdata_prevista']);
//            $this->db->set('procedimento_id', $_POST['procedimentoID']);
//            $this->db->set('data_prevista', $_POST['txtdata_prevista']);
            $this->db->set('medico_agendado', $_POST['medicoagenda']);
            $this->db->set('convenio', $_POST['convenio']);

            if (isset($_POST['orcamento'])) {
                $this->db->set('orcamento', 'true');
            } else {
                $this->db->set('orcamento', 'false');
//                $this->db->set('situacao', 'ORCAMENTO_COMPLETO');
            }

            if ($_POST['solicitacao_cirurgia_id'] == "0" || $_POST['solicitacao_cirurgia_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_solicitacao_cirurgia');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return -1;
                }
                $solicitacao_id = $this->db->insert_id();
            } else { // update
                $solicitacao_id = $_POST['solicitacao_cirurgia_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
                $this->db->update('tb_solicitacao_cirurgia');
                if (trim($erro) != "") { // erro de banco
                    return -1;
                }
            }

            return $solicitacao_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarsolicitacaoprocedimento() {

        try {
//            var_dump($_POST['procedimento_id']);die;

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

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

    function impressaoorcamento($solicitacao_id, $grau_participacao = null) {
        $this->db->select('fc.nome as grau_participacao,
                           sco.procedimento_tuss_id,
                           sco.operador_responsavel,
                           sco.valor,
                           sco.observacao,
                           sco.solicitacao_cirurgia_id,
                           pt.nome as procedimento,
                           pt.codigo,
                           c.nome as convenio,
                           o.nome as medico');
        $this->db->from('tb_solicitacao_cirurgia_orcamento sco');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = sco.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = sco.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sco.operador_responsavel', 'left');
        $this->db->join('tb_funcoes_cirurgia fc', 'fc.funcao_cirurgia_id = sco.grau_participacao', 'left');
        $this->db->where('sco.ativo', 'true');
        $this->db->where('sco.solicitacao_cirurgia_id', $solicitacao_id);
        if (isset($grau_participacao)) {
            $this->db->where('sco.grau_participacao', $grau_participacao);
        }
        $this->db->orderby('fc.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarfuncoes() {
        $this->db->select('*');
        $this->db->from('tb_funcoes_cirurgia');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarsolicitacaorcamento() {

        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $valor1 = str_replace(".", "", $_POST['valor1']);
            $valor1 = str_replace(",", ".", $valor1);
//            $this->db->set('operador_responsavel', $_POST['cirurgiao1']);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
//            $this->db->set('grau_participacao', $_POST['funcao']);
            $this->db->set('valor', $valor1);
            $this->db->set('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
            $this->db->set('observacao', $_POST['obs']);
            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_solicitacao_cirurgia_orcamento');

            $solicitacao_cirurgia_orcamento = $this->db->insert_id();

            if (isset($solicitacao_cirurgia_orcamento)) {
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('situacao', 'ORCAMENTO_INCOMPLETO');
                $this->db->where('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
                $this->db->update('tb_solicitacao_cirurgia');
            }


            if (trim($erro) != "") { // erro de banco
                return false;
            }

            return true;
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
