<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class centrocirurgico_model extends BaseModel {

    var $_centrocirurgico_id = null;
    var $_localizacao = null;
    var $_nome = null;

    function centrocirurgico_model($centrocirurgico_id = null) {
        parent::Model();
        if (isset($centrocirurgico_id)) {
            $this->instanciar($centrocirurgico_id);
        }
    }

    private function instanciar($centrocirurgico_id) {
        if ($centrocirurgico_id != 0) {

            $this->db->select('centrocirurgico_id,
                            nome');
            $this->db->from('tb_solicitacao_cirurgia');
            $this->db->where('ativo', 'true');
            $this->db->where('excluido', 'false');
            $this->db->where('centrocirurgico_id', $centrocirurgico_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_centrocirurgico_id = $centrocirurgico_id;
            $this->_nome = $return[0]->nome;
        }
    }

    function listarsolicitacoes($args = array()) {

        $this->db->select(' p.paciente_id,
                            p.nome,
                            sc.solicitacao_cirurgia_id,
                            sc.data_prevista,
                            sc.orcamento,
                            c.nome as convenio,
                            c.convenio_id,
                            o.nome as medico,
                            sc.situacao');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->where('sc.autorizado', 'f');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_agendado', 'left');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listarhospitais($args = array()) {

        $this->db->select('hospital_id, 
                               f.nome,
                               razao_social,
                               cnpj,
                               celular,
                               telefone,
                               cep,
                               logradouro,
                               numero,
                               bairro,
                               cnes,
                               f.municipio_id,
                               c.nome as municipio,
                               c.estado,
                               cep');
        $this->db->from('tb_hospital f');
        $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
        $this->db->where('f.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('f.nome ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function relatoriomedicoprocedimentosguiacirurgica() {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.data,
                            a.tipo,
                            a.guia_id,
                            c.nome as convenio,
                            a.horario_especial,
                            a.procedimento_tuss_id,
                            a.valor_total,
                            pt.nome as procedimento,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("a.tipo", "CIRURGICO");
        $this->db->orderby("a.guia_id");
        $this->db->orderby("a.valor_total DESC");
//        $this->db->limit(5);
        $return = $this->db->get();
        return $return->result();
    }

    function listarequipeoperadores($guia_id) {
        $this->db->select('DISTINCT(o.nome) as medico,
                           gp.descricao as funcao');
        $this->db->from('tb_agenda_exame_equipe aee');
        $this->db->join('tb_operador o', 'o.operador_id = aee.operador_responsavel', 'left');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = aee.funcao', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = aee.agenda_exames_id', 'left');
        $this->db->where('ae.guia_id', $guia_id);
        $this->db->groupby('o.nome, gp.descricao, aee.agenda_exame_equipe_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentosguiacirurgica($guia) {
        $data = date("Y-m-d");
        $this->db->select('a.agenda_exames_id,
                            a.data,
                            a.tipo,
                            a.horario_especial,
                            a.procedimento_tuss_id,
                            a.valor_total,
                            pt.nome as procedimento,
                            c.nome as convenio,
                            a.observacoes');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = a.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("a.guia_id", $guia);
        $this->db->orderby("a.valor_total DESC");
//        $this->db->limit(5);
        $return = $this->db->get();
        return $return->result();
    }

    function listarequipecirurgica($args = array()) {

        $this->db->select('equipe_cirurgia_id, 
                           nome');
        $this->db->from('tb_equipe_cirurgia ec');
        $this->db->where('ec.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('ec.nome ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listarequipecirurgica2() {

        $this->db->select('equipe_cirurgia_id, 
                           nome');
        $this->db->from('tb_equipe_cirurgia ec');
        $this->db->where('ec.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listargrauparticipacao($args = array()) {

        $this->db->select('grau_participacao_id, 
                           codigo,
                           descricao');
        $this->db->from('tb_grau_participacao ec');
        $this->db->where('ec.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('ec.descricao ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function instanciarhospitais($hospital_id) {

        $this->db->select('hospital_id, 
                               f.nome,
                               razao_social,
                               cnpj,
                               celular,
                               telefone,
                               cep,
                               logradouro,
                               numero,
                               bairro,
                               cnes,
                               f.municipio_id,
                               c.nome as municipio,
                               c.estado,
                               cep');
        $this->db->from('tb_hospital f');
        $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
        $this->db->where('f.hospital_id', $hospital_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacoes2($args = array()) {

        $this->db->select(' p.paciente_id,
                            p.nome,
                            sc.solicitacao_cirurgia_id,
                            sc.data_prevista,
                            sc.orcamento,
                            c.nome as convenio,
                            c.convenio_id,
                            o.nome as medico,
                            sc.situacao');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->where('sc.autorizado', 'f');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_agendado', 'left');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listarcirurgia($args = array()) {

        $this->db->select(' p.paciente_id,
                            p.nome,
                            sc.solicitacao_cirurgia_id,
                            sc.data_prevista');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_internacao i', 'i.internacao_id = sc.internacao_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id ', 'left');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->where('sc.autorizado', 't');

        if ($args) {
            if (isset($args['txtdata_cirurgia']) && strlen($args['txtdata_cirurgia']) > 0) {
                $pesquisa = $args['txtdata_cirurgia'];
                $pesquisa1 = $pesquisa . ' 00:00:00';
                $pesquisa2 = $pesquisa . ' 23:59:59';
                $this->db->where("sc.data_prevista >=", "$pesquisa1");
                $this->db->where("sc.data_prevista <=", "$pesquisa2");
                if ($args['nome'] != null) {
                    $this->db->where('nome ilike', "%" . $args['nome'] . "%");
                }
            } else if ($args['nome'] != null) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
            }
        } else {
            $hoje = date('Y-m-d');
            $hoje = $hoje . ' 00:00:00';
            $this->db->where("sc.data_prevista >=", "$hoje");
        }

        return $this->db;
    }

    function listacentrocirurgicoautocomplete($parametro = null) {
        $this->db->select('centrocirurgico_id,
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

    function listarsalas() {
        $this->db->select('exame_sala_id,
                           nome');
        $this->db->from('tb_exame_sala');
        $this->db->where('ativo', 'true');

        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoguiascirurgicas() {
        $this->db->select('ambulatorio_guia_id,
                           equipe_id');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where('tipo', 'CIRURGICO');

        $return = $this->db->get();
        return $return->result();
    }

    function gravarequipeoperadores() {
        try {
            /* inicia o mapeamento no banco */
            $_POST['valor'] = (float) str_replace(',', '.', str_replace('.', '', $_POST['valor']));

            $this->db->set('funcao', $_POST['funcao']);
            $this->db->set('operador_responsavel', $_POST['medico']);
            $this->db->set('solicitacao_cirurgia_id', $_POST['solicitacao_id']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_equipe_cirurgia_operadores');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function finalizarcadastroequipecirurgica($guia_id) {
        try {
            /* inicia o mapeamento no banco */
            
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('equipe', 't');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_guia_id', $guia_id);
            $this->db->update('tb_ambulatorio_guia');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return false;
            else
                return true;;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarhospital() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);
//            $this->db->set('razao_social', $_POST['txtrazaosocial']);
//            $this->db->set('cep', $_POST['CEP']);
//            $this->db->set('cnes', $_POST['txtCNES']);
            if ($_POST['txtCNPJ'] != '') {
                $this->db->set('cnpj', str_replace("-", "", str_replace("/", "", str_replace(".", "", $_POST['txtCNPJ']))));
            }
            $this->db->set('telefone', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['telefone']))));
            $this->db->set('celular', str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST['celular']))));
            if ($_POST['municipio_id'] != '') {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }
            $this->db->set('cep', $_POST['cep']);
            $this->db->set('logradouro', $_POST['endereco']);
            $this->db->set('numero', $_POST['numero']);
            $this->db->set('bairro', $_POST['bairro']);



            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtempresaid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_hospital');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $hospital_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $hospital_id = $_POST['txtempresaid'];
                $this->db->where('hospital_id', $hospital_id);
                $this->db->update('tb_hospital');
            }
            return $hospital_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluirequipecirurgica($equipe_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('equipe_cirurgia_id', $equipe_id);
            $this->db->update('tb_equipe_cirurgia');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluirgrauparticipacao($grau_participacao_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('grau_participacao_id', $grau_participacao_id);
            $this->db->update('tb_grau_participacao');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function excluirhospital($hospital_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('hospital_id', $hospital_id);
            $this->db->update('tb_hospital');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravargrauparticipacao() {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('codigo', $_POST['txtcodigo']);
        $this->db->set('descricao', $_POST['txtNome']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_grau_participacao');
    }

    function pegasolicitacaoinformacoes($solicitacao_id) {
        $this->db->select(' p.paciente_id,
                            p.nome,
                            sc.solicitacao_cirurgia_id,
                            sc.medico_agendado');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id ');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->where('sc.solicitacao_cirurgia_id', $solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function liberarsolicitacao($solicitacao_id, $orcamento) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
//        var_dump($orcamento);die;

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        if ($orcamento != 'f') {
            $this->db->set('situacao', 'LIBERADA');
        } else {
            $this->db->set('situacao', 'ORCAMENTO_COMPLETO');
        }
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->update('tb_solicitacao_cirurgia');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function alterarsituacaoorcamento($solicitacao_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('situacao', 'ORCAMENTO_INCOMPLETO');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->update('tb_solicitacao_cirurgia');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function alterarsituacaoorcamentodisnecessario($solicitacao_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('situacao', 'ORCAMENTO_COMPLETO');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->update('tb_solicitacao_cirurgia');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function verificasituacao($solicitacao_id) {
        $this->db->select('situacao');
        $this->db->from('tb_solicitacao_cirurgia');
        $this->db->where('ativo', 't');
        $this->db->where('excluido', 'f');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function finalizarrcamento($solicitacao_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('situacao', 'ORCAMENTO_COMPLETO');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->update('tb_solicitacao_cirurgia');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function finalizarequipe($solicitacao_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('situacao', 'EQUIPE_MONTADA');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->update('tb_solicitacao_cirurgia');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function autorizarcirurgia() {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $_POST['dataprevista'] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['dataprevista'])));

        $this->db->set('data_prevista', $_POST['dataprevista']);
        $this->db->set('medico_agendado', $_POST['medicoagendadoid']);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('sala_agendada', $_POST['salaagendada']);
        $this->db->set('autorizado', 't');
        $this->db->set('situacao', 'AUTORIZADA');
        $this->db->where('solicitacao_cirurgia_id', $_POST['idsolicitacaocirurgia']);
        $this->db->update('tb_solicitacao_cirurgia');
    }

    function relatoriomedicoequipecirurgicaoperadores() {
        $this->db->select('gp.descricao,
                           gp.codigo,
                           eco.funcao,
                           eco.equipe_cirurgia_id,
                           o.operador_id,
                           o.nome as medico_responsavel');
        $this->db->from('tb_equipe_cirurgia_operadores eco');
        $this->db->join('tb_operador o', 'o.operador_id = eco.operador_responsavel');
        $this->db->join('tb_grau_participacao gp', 'gp.grau_participacao_id = eco.funcao');
        $this->db->where('eco.ativo', 'true');
//        $this->db->where('equipe_cirurgia_id', $equipe_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarequipecirurgicaoperadores($equipe_id) {
        $this->db->select('gp.descricao,
                           gp.codigo,
                           eco.funcao,
                           o.operador_id,
                           o.nome as medico_responsavel');
        $this->db->from('tb_equipe_cirurgia_operadores eco');
        $this->db->join('tb_operador o', 'o.operador_id = eco.operador_responsavel');
        $this->db->join('tb_grau_participacao gp', 'gp.grau_participacao_id = eco.funcao');
//        $this->db->orderby('ativo', 'true');
        $this->db->where('equipe_cirurgia_id', $equipe_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarmedicocirurgiaautocomplete($parametro = null) {
        $this->db->select('operador_id,
                           nome');
        $this->db->from('tb_operador');
        $this->db->where('consulta', 'true');
        $this->db->where('ativo', 'true');
//        $this->db->orderby('nome');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function gravarcentrocirurgico() {

        try {
            $this->db->set('nome', $_POST['nome']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['centrocirurgico_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_solicitacao_cirurgia');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $centrocirurgico_id = $this->db->insert_id();
            }
            else { // update
                $centrocirurgico_id = $_POST['centrocirurgico_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('centrocirurgico_id', $centrocirurgico_id);
                $this->db->update('tb_solicitacao_cirurgia');
            }


            return $centrocirurgico_id;
        } catch (Exception $exc) {
            return false;
        }
    }

}
?>

