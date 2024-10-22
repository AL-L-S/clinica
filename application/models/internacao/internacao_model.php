<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class internacao_model extends BaseModel {

    var $_paciente_id = null;
    var $_nome = null;

    function internacao_model($emergencia_solicitacao_acolhimento_id = null) {
        parent::Model();
        if (isset($emergencia_solicitacao_acolhimento_id)) {
            $this->instanciar($emergencia_solicitacao_acolhimento_id);
        }
    }

    function listarultimoprecadastro($paciente_id, $internacao_ficha_id) {


        $this->db->select('idade_inicio, tipo_dependencia, grau_parentesco, ocupacao_responsavel, nome');
        $this->db->from('tb_internacao_ficha_questionario ');
        if ($internacao_ficha_id > 0) {
            $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_id);
        } else {
            $this->db->where('paciente_id', $paciente_id);
        }
        $this->db->orderby('data_cadastro desc');
        $this->db->limit(1);

        $return = $this->db->get()->result();

        return $return;
    }

    function excluirinternacao($internacao_id, $paciente_id, $leito_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('internacao_id', $internacao_id);
        $this->db->set('leito_id', $leito_id);
        $this->db->set('tipo', 'SAIDA');
        $this->db->set('status', 'SAIDA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');

        //Tabela internação alteração

        $this->db->set('excluido', 't');

        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('internacao_id', $internacao_id);
        $this->db->update('tb_internacao');

        //Tabela Ocupação alteração
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('ocupado', 'f');
        $this->db->where('paciente_id', $paciente_id);
        $this->db->update('tb_internacao_ocupacao');

        //Tabela internacao_leito

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('ativo', 't');
        $this->db->where('internacao_leito_id', $leito_id);
        $this->db->update('tb_internacao_leito');
    }

    function gravar($paciente_id) {
        $empresa_id = $this->session->userdata('empresa_id');

        try {
            $this->db->select('valortotal');
            $this->db->from('tb_procedimento_convenio');
            $this->db->where('procedimento_convenio_id', $_POST['procedimento1']);
            $return = $this->db->get()->result();
//            var_dump($return); die;
            $this->db->set('leito', $_POST['leitoID']);
            $this->db->set('codigo', $_POST['sisreg']);
            $this->db->set('aih', $_POST['aih']);
            $this->db->set('senha', $_POST['senha']);
            $this->db->set('prelaudo', $_POST['central']);
            $this->db->set('medico_id', $_POST['operadorID']);
            $this->db->set('data_internacao', date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['data']))));
            $this->db->set('forma_de_entrada', $_POST['forma']);
            $this->db->set('estado', $_POST['estado']);
            $this->db->set('carater_internacao', $_POST['carater']);
            $this->db->set('procedimento_convenio_id', $_POST['procedimento1']);
            if (count($return) > 0) {
                $this->db->set('valor_total', @$return[0]->valortotal);
            }

            $this->db->set('cid1solicitado', $_POST['cid1ID']);
            $this->db->set('cid2solicitado', $_POST['cid2ID']);
            $this->db->set('justificativa', $_POST['observacao']);
            $this->db->set('nome_responsavel', $_POST['nome_responsavel']);
            $this->db->set('cep_responsavel', $_POST['cep_responsavel']);
            $this->db->set('logradouro_responsavel', $_POST['logradouro_responsavel']);
            $this->db->set('numero_responsavel', $_POST['numero_responsavel']);
//            $this->db->set('complemento_responsavel', $_POST['complemento_responsavel']);
            $this->db->set('bairro_responsavel', $_POST['bairro_responsavel']);
            $this->db->set('rg_responsavel', $_POST['rg_responsavel']);
//            $this->db->set('cpf_responsavel', $_POST['cpf_responsavel']);
            $this->db->set('cpf_responsavel', str_replace("-", "", str_replace(".", "", $_POST['cpf_responsavel'])));
            $this->db->set('email_responsavel', $_POST['email_responsavel']);
            $this->db->set('celular_responsavel', $_POST['celular_responsavel']);
            $this->db->set('telefone_responsavel', $_POST['telefone_responsavel']);
            $this->db->set('grau_parentesco', $_POST['grau_parentesco']);
            $this->db->set('ocupacao_responsavel', $_POST['ocupacao_responsavel']);
            $this->db->set('empresa_id', $empresa_id);

            if ($_POST['municipio_responsavel_id'] != '') {
                $this->db->set('municipio_responsavel_id', $_POST['municipio_responsavel_id']);
            }
//            echo '<pre>';
//            var_dump($_POST); die;
            $tipo_json = json_encode($_POST['tipo_dependencia']);
            // if ($_POST['tipo_dependencia'] > 0) {
            $this->db->set('tipo_dependencia', $tipo_json);
            // }
            if ($_POST['idade_inicio'] > 0) {
                $this->db->set('idade_inicio', $_POST['idade_inicio']);
            }

            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao');

                $internacao_id = $this->db->insert_id();

                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $internacao_id = $this->db->insert_id();
                $this->db->set('ativo', 'false');
                $this->db->where('internacao_leito_id', $_POST['leitoID']);
                $this->db->update('tb_internacao_leito');

                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('leito_id', $_POST['leitoID']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_ocupacao');

                $this->db->set('internacao_id', $internacao_id);
                $this->db->set('leito_id', $_POST['leitoID']);
                $this->db->set('tipo', 'ENTRADA');
                $this->db->set('status', 'INTERNACAO');
                $this->db->set('data', $_POST['data']);
                $this->db->set('operador_movimentacao', $operador_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_leito_movimentacao');




                $this->db->set('procedimento_convenio_id', $_POST['procedimento1']);
                if (count($return) > 0) {
                    $this->db->set('valor_total', @$return[0]->valortotal);
                    $this->db->set('valor1', @$return[0]->valortotal);
                }

                $this->db->set('quantidade', 1);
                $this->db->set('empresa_id', $empresa_id);

                $this->db->set('ativo', 't');
                if ($_POST['operadorID'] != "") {
                    $this->db->set('medico_id', $_POST['operadorID']);
                }
                $this->db->set('faturado', 'f');
                $this->db->set('internacao_id', $internacao_id);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
//            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_procedimentos');
            } else { // update
                $internacao_id = $_POST['internacao_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_id', $internacao_id);
                $this->db->update('tb_internacao');
            }


            return $internacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarobservacaoprecadastro($internacao_ficha_questionario_id) {
        $empresa_id = $this->session->userdata('empresa_id');

        try {

//            var_dump($_POST); die;

            $this->db->set('observacao', $_POST['txtobservacao']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
            $this->db->update('tb_internacao_ficha_questionario');



            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarretornarinternacao($internacao_id) {
        $empresa_id = $this->session->userdata('empresa_id');

        try {

//            var_dump($return); die;

            $this->db->set('ativo', 't');
            $this->db->set('leito', $_POST['leitoID']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_id', $internacao_id);
            $this->db->update('tb_internacao');

            $this->db->set('ativo', 'false');
            $this->db->where('internacao_leito_id', $_POST['leitoID']);
            $this->db->update('tb_internacao_leito');

            $this->db->set('paciente_id', $_POST['idpaciente']);
            $this->db->set('leito_id', $_POST['leitoID']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_ocupacao');

            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('leito_id', $_POST['leitoID']);
            $this->db->set('tipo', 'ENTRADA');
            $this->db->set('status', 'INTERNACAO');
            $this->db->set('data', date("Y-m-d"));
            $this->db->set('operador_movimentacao', $operador_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_leito_movimentacao');

            return $internacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function listarmodelogrupoquestionario() {

        $this->db->select('im.internacao_modelo_grupo_id, im.nome, e.nome as empresa, im.texto');
        $this->db->from('tb_internacao_modelo_grupo im');
        $this->db->join('tb_empresa e', 'im.empresa_id = e.empresa_id', 'left');
        $this->db->where('im.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarmodelogrupo() {

        $this->db->select('im.internacao_modelo_grupo_id, im.nome, e.nome as empresa');
        $this->db->from('tb_internacao_modelo_grupo im');
        $this->db->join('tb_empresa e', 'im.empresa_id = e.empresa_id', 'left');
        $this->db->where('im.ativo', 't');
        return $this->db;
    }

    function listarautocompletemodelosgrupo($internacao_modelo_grupo_id = null) {

        $this->db->select('im.*');
        $this->db->from('tb_internacao_modelo_grupo im');
//        $this->db->join('tb_empresa_id e', 'im.empresa_id = e.empresa_id', 'left');
        if ($internacao_modelo_grupo_id != null) {
            $this->db->where('im.internacao_modelo_grupo_id', $internacao_modelo_grupo_id);
        }

        $return = $this->db->get();
        return $return->result();
    }

    function listarmodelogrupoform($internacao_modelo_grupo_id) {

        $this->db->select('im.*');
        $this->db->from('tb_internacao_modelo_grupo im');
//        $this->db->join('tb_empresa_id e', 'im.empresa_id = e.empresa_id', 'left');
        $this->db->where('im.internacao_modelo_grupo_id', $internacao_modelo_grupo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarfichaquestionario($args = array()) {

        $this->db->select('if.internacao_ficha_questionario_id, 
                             if.nome, 
                             p.nome as paciente, 
                             o.nome as operador, 
                             if.data_cadastro,
                             if.paciente_id,
                             if.observacao,
                             if.confirmado,
                             if.aprovado');
        $this->db->from('tb_internacao_ficha_questionario if');
        $this->db->join('tb_operador o', 'o.operador_id = if.operador_cadastro', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = if.paciente_id', 'left');
        $this->db->where('if.ativo', 't');

        if (isset($args['confirmado']) && strlen($args['confirmado']) > 0) {
            $this->db->where('if.confirmado', $args['confirmado']);
        }
        if (isset($args['aprovado']) && strlen($args['aprovado']) > 0) {
            $this->db->where('if.aprovado', $args['aprovado']);
        }
        if (isset($args['data_inicio']) && strlen($args['data_inicio']) > 0) {
            $this->db->where('if.data_cadastro >=', date("Y-m-d", strtotime(str_replace('/', '-', $args['data_inicio']))) . ' 00:00:00');
        }
        if (isset($args['data_fim']) && strlen($args['data_fim']) > 0) {
            $this->db->where('if.data_cadastro <=', date("Y-m-d", strtotime(str_replace('/', '-', $args['data_fim']))) . ' 23:59:59');
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', '%' . $args['nome'] . '%');
        }
//        var_dump(date("Y-m-d",strtotime($args['data_inicio']))); die;

        return $this->db;
    }

    function listastatusinternacao($args = array()) {

        $this->db->select(' internacao_statusinternacao_id,
                            dias_status,
                            nome');
        $this->db->from('tb_internacao_statusinternacao');
        $this->db->where('ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('nome ilike', "%" . $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listarstatuspacientetodos() {

        $this->db->select('ist.internacao_statusinternacao_id, 
                            ist.nome, 
                            ist.color, 
                            ist.dias_status, 
                            ist.observacao, 
                             ');
        $this->db->from('tb_internacao_statusinternacao ist');
        $this->db->where('ist.ativo', 't');
        $this->db->orderby('ist.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function novostatusinternacao($internacao_ficha_questionario_id) {

        $this->db->select('ist.internacao_statusinternacao_id, 
                            ist.nome, 
                            ist.color, 
                            ist.dias_status, 
                            ist.observacao, 
                             ');
        $this->db->from('tb_internacao_statusinternacao ist');
        $this->db->where('ist.internacao_statusinternacao_id', $internacao_ficha_questionario_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarstatuspaciente($internacao_id) {

        $this->db->select('ist.internacao_statusinternacao_id, 
                            ist.nome, 
                            ist.color, 
                            ist.dias_status, 
                            ist.observacao, 
                             ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_statusinternacao ist', 'ist.internacao_statusinternacao_id = i.internacao_statusinternacao_id', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarstatuspaciente($internacao_id) {

        try {
            $this->db->set('internacao_statusinternacao_id', $_POST['status']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_status', $horario);
            $this->db->set('operador_status', $operador_id);
            $this->db->where('internacao_id', $internacao_id);
            $this->db->update('tb_internacao');
            return $internacao_id;

        } catch (Exception $exc) {
            return false;
        }
    }


    function gravarstatusinternacao() {

        try {
            $this->db->set('nome', $_POST['nome']);
            $this->db->set('observacao', $_POST['observacao']);
            $this->db->set('color', $_POST['color']);
            $this->db->set('dias_status', $_POST['dias_status']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['internacao_statusinternacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_statusinternacao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $internacao_statusinternacao_id = $this->db->insert_id();
            }
            else { // update
                $internacao_statusinternacao_id = $_POST['internacao_statusinternacao_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_statusinternacao_id', $internacao_statusinternacao_id);
                $this->db->update('tb_internacao_statusinternacao');
            }

            return $internacao_statusinternacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function observacaoprecadastros($internacao_ficha_questionario_id) {

        $this->db->select('if.internacao_ficha_questionario_id, 
                             if.observacao, 
                             if.observacao_ligacao, 
                             if.data_cadastro,
                             ');
        $this->db->from('tb_internacao_ficha_questionario if');
        $this->db->where('if.ativo', 't');
        $this->db->where('if.internacao_ficha_questionario_id', $internacao_ficha_questionario_id);


//        var_dump(date("Y-m-d",strtotime($args['data_inicio']))); die;

        $return = $this->db->get();
        return $return->result();
    }

    function listarfichaquestionarioform($internacao_ficha_questionario_id) {

        $this->db->select('im.*, p.nome as paciente,p.idade, p.nascimento, p.sexo, m.nome as cidade');
        $this->db->from('tb_internacao_ficha_questionario im');
        $this->db->join('tb_paciente p', 'p.paciente_id = im.paciente_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = im.municipio_id', 'left');
        $this->db->where('im.internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listartipodependencia() {

        $this->db->select('im.internacao_tipo_dependencia_id, im.nome');
        $this->db->from('tb_internacao_tipo_dependencia im');
//        $this->db->join('tb_empresa e', 'im.empresa_id = e.empresa_id', 'left');
        $this->db->where('im.ativo', 't');
        return $this->db;
    }

    function listartipodependenciaform($internacao_tipo_dependencia_id) {

        $this->db->select('im.*');
        $this->db->from('tb_internacao_tipo_dependencia im');
//        $this->db->join('tb_empresa_id e', 'im.empresa_id = e.empresa_id', 'left');
        $this->db->where('im.internacao_tipo_dependencia_id', $internacao_tipo_dependencia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listartipodependenciaquestionario() {

        $this->db->select('im.*');
        $this->db->from('tb_internacao_tipo_dependencia im');
//        $this->db->join('tb_empresa_id e', 'im.empresa_id = e.empresa_id', 'left');
//        $this->db->where('im.internacao_tipo_dependencia_id', $internacao_tipo_dependencia_id);
        $this->db->where('im.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function mostrartermoresponsabilidade($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.*,
                           p.paciente_id,
                           i.prelaudo,
                           o.nome as medico,
                           o.conselho,
                           i.data_internacao,
                           i.data_saida,
                           i.senha,
                           i.forma_de_entrada,
                           i.estado,
                           i.idade_inicio,
                           il.nome as leito,
                           m.nome as municio,
                           mr.nome as municipio_responsavel,
                           m.codigo_ibge,
                           i.cid1solicitado,
                           pt.nome as procedimento,
                           i.procedimentosolicitado,
                           c.nome as convenio,
                           cbo.descricao as profissao,
                           i.nome_responsavel,
                           i.cep_responsavel,
                           i.logradouro_responsavel,
                           i.numero_responsavel,
                           i.complemento_responsavel,
                           i.bairro_responsavel,
                           i.municipio_responsavel_id,
                           i.rg_responsavel,
                           i.cpf_responsavel,
                           i.email_responsavel,
                           i.motivo_saida,
                           i.celular_responsavel,
                           i.telefone_responsavel,
                           i.grau_parentesco,
                           i.idade_inicio,
                           i.tipo_dependencia,
                           ocupacao_responsavel,
                           cid.co_cid,
                           cid.no_cid,
                           cid2.co_cid as co_cid2,
                           cid2.no_cid as no_cid2,
                           p.sexo,
                           p.estado_civil_id,
                           p.nascimento');
        $this->db->from('tb_internacao i');
        // $this->db->join('tb_internacao_tipo_dependencia itd', 'itd.internacao_tipo_dependencia_id = i.tipo_dependencia', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_cid cid2', 'cid2.co_cid = i.cid2solicitado', 'left');
        $this->db->join('tb_municipio mr', 'mr.municipio_id = i.municipio_responsavel_id', 'left');
        
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'i.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = i.leito', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function imprimirevolucaointernacao($internacao_evolucao_id) {

        $this->db->select('i.internacao_id,
                           p.nome,
                           p.paciente_id,
                           ie.operador_cadastro,
                           ie.data_cadastro,
                           ie.internacao_evolucao_id,
                           i.prelaudo,
                           o.nome as medico,
                           o.conselho,
                           i.data_internacao,
                           i.data_saida,
                           i.senha,
                           ie.diagnostico,

                           p.nascimento');
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->join('tb_internacao i', 'ie.internacao_id = i.internacao_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ie.operador_cadastro', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_cid cid2', 'cid2.co_cid = i.cid2solicitado', 'left');
        $this->db->join('tb_municipio mr', 'mr.municipio_id = i.municipio_responsavel_id', 'left');
        
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'i.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = i.leito', 'left');
        $this->db->where('ie.internacao_evolucao_id', $internacao_evolucao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function imprimirevolucaointernacaotodas($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.nome,
                           p.paciente_id,
                           ie.operador_cadastro,
                           ie.internacao_evolucao_id,
                           i.prelaudo,
                           o.nome as medico,
                           o.conselho,
                           i.data_internacao,
                           i.data_saida,
                           i.senha,
                           cbo.descricao as especialidade,
                           ie.diagnostico,
                           ie.data_cadastro,

                           p.nascimento');
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->join('tb_internacao i', 'ie.internacao_id = i.internacao_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ie.operador_cadastro', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_cid cid2', 'cid2.co_cid = i.cid2solicitado', 'left');
        $this->db->join('tb_municipio mr', 'mr.municipio_id = i.municipio_responsavel_id', 'left');
        
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = o.cbo_ocupacao_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'i.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = i.leito', 'left');
        $this->db->where('ie.internacao_id', $internacao_id);
        $this->db->orderby('ie.internacao_evolucao_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarinformacoesinternacao($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.*,
                           p.paciente_id,
                           i.prelaudo,
                           o.nome as medico,
                           o.conselho,
                           i.data_internacao,
                           i.data_saida,
                           i.forma_de_entrada,
                           i.estado,
                           i.idade_inicio,
                           il.nome as leito,
                           m.nome as municio,
                           mr.nome as municipio_responsavel,
                           m.codigo_ibge,
                           i.cid1solicitado,
                           pt.nome as procedimento,
                           i.procedimentosolicitado,
                           c.nome as convenio,
                           cbo.descricao as profissao,
                           itd.nome as dependencia,
                           i.nome_responsavel,
                           i.cep_responsavel,
                           i.logradouro_responsavel,
                           i.numero_responsavel,
                           i.complemento_responsavel,
                           i.bairro_responsavel,
                           i.municipio_responsavel_id,
                           i.rg_responsavel,
                           i.cpf_responsavel,
                           i.email_responsavel,
                           i.motivo_saida,
                           i.celular_responsavel,
                           i.telefone_responsavel,
                           i.grau_parentesco,
                           i.idade_inicio,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           c.nome as convenio,
                           ocupacao_responsavel,
                           cid.co_cid,
                           cid.no_cid,
                           cid2.co_cid as co_cid2,
                           cid2.no_cid as no_cid2,
                           p.sexo,
                           p.estado_civil_id,
                           p.nascimento');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_tipo_dependencia itd', 'itd.internacao_tipo_dependencia_id = i.tipo_dependencia', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_cid cid2', 'cid2.co_cid = i.cid2solicitado', 'left');
        $this->db->join('tb_municipio mr', 'mr.municipio_id = i.municipio_responsavel_id', 'left');
//        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'i.procedimento_convenio_id = pc.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = i.leito', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarinternacaonutricao($paciente_id) {

        try {
            if ($_POST['leito'] != "") {
                $this->db->set('leito', $_POST['leito']);
            }
            $this->db->set('codigo', $_POST['sisreg']);
            $this->db->set('aih', $_POST['aih']);
            if ($_POST['unidade'] != "") {
                $this->db->set('hospital_id', $_POST['unidade']);
            }
            if ($_POST['data_internacao'] != "") {
                $this->db->set('data_internacao', $_POST['data_internacao']);
            }
            if ($_POST['data_solicitacao'] != "") {
                $this->db->set('data_solicitacao', $_POST['data_solicitacao']);
            }
            $this->db->set('carater_internacao', $_POST['carater']);
            $this->db->set('procedimentosolicitado', $_POST['procedimentoID']);
            $this->db->set('cid1solicitado', $_POST['cid1ID']);
            $this->db->set('justificativa', $_POST['observacao']);
            $this->db->set('solicitante', $_POST['solicitante']);
            $this->db->set('reg', $_POST['reg']);
            $this->db->set('val', $_POST['val']);
            $this->db->set('pla', $_POST['pla']);
            $this->db->set('rx', $_POST['rx']);
            $this->db->set('acesso', $_POST['acesso']);
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao');
                $internacao_id = $this->db->insert_id();
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return 0;
                } elseif ($_POST['leito'] != "") {
                    $this->db->set('ativo', 'false');
                    $this->db->set('condicao', 'Ocupado');
                    $this->db->where('internacao_leito_id', $_POST['leito']);
                    $this->db->update('tb_internacao_leito');

                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('leito_id', $_POST['leito']);
                    $this->db->set('ocupado', 'false');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_internacao_ocupacao');
                }
            } else { // update
                $internacao_id = $_POST['internacao_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_id', $internacao_id);
                $this->db->update('tb_internacao');
            }


            return $internacao_id;
        } catch (Exception $exc) {
            return 0;
        }
    }

    function mostrarsaidapaciente($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.nome as paciente,
                           m.nome as motivosaida,
                           i.motivo_saida,
                           i.hospital_transferencia,
                           m.internacao_motivosaida_id,
                           p.paciente_id,
                           i.data_internacao,
                           i.observacao_saida,
                           i.leito,
                           p.sexo,
                           p.nascimento');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->join('tb_internacao_motivosaida m', 'm.internacao_motivosaida_id = i.motivo_saida', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
//        $this->db->where('p.paciente_id = i.paciente_id');
//        $this->db->where('o.operador_id = i.medico_id');
        // $this->db->where('m.internacao_motivosaida_id = i.motivo_saida ');

        $return = $this->db->get();
        return $return->result();
    }

    function gravarevolucaointernacao() {
        $operador_id = ($this->session->userdata('operador_id'));
        $horario = date("Y-m-d H:i:s");


        $this->db->set('diagnostico', $_POST['txtdiagnostico']);
        // $this->db->set('conduta', $_POST['txtconduta']);
        $this->db->set('internacao_id', $_POST['internacao_id']);

        if (@$_POST['internacao_evolucao_id'] != '') {
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_evolucao_id', $_POST['internacao_evolucao_id']);
            $this->db->update('tb_internacao_evolucao');
        } else {
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_evolucao');
            $this->db->insert_id();
        }


        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function gravarprocedimentoexternointernacao() {
        $operador_id = ($this->session->userdata('operador_id'));
        $horario = date("Y-m-d H:i:s");


        $this->db->set('procedimento', $_POST['procedimento']);
        $this->db->set('data', date("Y-m-d", strtotime(str_replace('/','-',$_POST['data']))));
        $this->db->set('duracao', $_POST['duracao']);
        $this->db->set('observacao', $_POST['observacao']);
        // $this->db->set('conduta', $_POST['txtconduta']);
        $this->db->set('internacao_id', $_POST['internacao_id']);

        if (@$_POST['internacao_procedimentoexterno_id'] > 0) {
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_procedimento_externo_id', $_POST['internacao_procedimentoexterno_id']);
            $this->db->update('tb_internacao_procedimento_externo');
        } else {
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_procedimento_externo');
            $this->db->insert_id();
        }


        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function excluirprocedimentoexternointernacao($internacao_proc_id) {
        $operador_id = ($this->session->userdata('operador_id'));
        $horario = date("Y-m-d H:i:s");

        $this->db->set('ativo', 'f');
        // $this->db->set('data', date("Y-m-d", strtotime(str_replace('/','-',$_POST['data']))));
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('internacao_procedimento_externo_id', $internacao_proc_id);
        $this->db->update('tb_internacao_procedimento_externo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function excluirevolucaointernacao($internacao_evolucao_id) {
        $operador_id = ($this->session->userdata('operador_id'));
        $horario = date("Y-m-d H:i:s");

        $this->db->set('ativo', 'false');
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->where('internacao_evolucao_id', $internacao_evolucao_id);
        $this->db->update('tb_internacao_evolucao');


        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function gravarprescricaoenteralnormal($internacao_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('internacao_precricao_id');
        $this->db->from('tb_internacao_precricao');
        $this->db->where("internacao_id", $internacao_id);
        $this->db->where("data", $dataprescricao);
        $query = $this->db->get();
        $return = $query->result();

        $numero = count($return);

        if ($numero == 0) {
            $this->db->set('data', $dataprescricao);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao');
            $internacao_precricao_id = $this->db->insert_id();
        } else {
            $internacao_precricao_id = $return[0]->internacao_precricao_id;
        }

        if ($_POST['produto'] != "Selecione") {

            $this->db->set('etapas', $_POST['etapas']);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id = $this->db->insert_id();

            $i = 0;
            foreach ($_POST['produto'] as $produto) {
                $z = 0;
                $c = 0;
                $i++;
                foreach ($_POST['volume'] as $itemvolume) {
                    $c++;
                    if ($i == $c) {
                        $volume = $itemvolume;
                        break;
                    }
                }
                foreach ($_POST['vazao'] as $itemvazao) {
                    $z++;
                    if ($i == $z) {
                        $vazao = $itemvazao;
                        break;
                    }
                }

                $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id);
                $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                $this->db->set('internacao_id', $internacao_id);
                $this->db->set('etapas', $_POST['etapas']);
                $this->db->set('tipo', 'ENTERALNORMAL');
                if ($produto != "Selecione") {
                    $this->db->set('produto_id', $produto);
                }
                if ($volume != null) {
                    $this->db->set('volume', $volume);
                }
                if ($vazao != null) {
                    $this->db->set('vasao', $vazao);
                }
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_precricao_produto');
                $internacao_precricao_produto_id = $this->db->insert_id();
            }
        }

        if ($_POST['equipo'] != "Selecione") {

            $this->db->set('etapas', 1);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id_equipo = $this->db->insert_id();

            $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id_equipo);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('etapas', 1);
            $this->db->set('tipo', 'ENTERALNORMAL');
            $this->db->set('produto_id', $_POST['equipo']);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_produto');
        }
    }

    function gravarprescricaoenteralemergencial($internacao_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('internacao_precricao_id');
        $this->db->from('tb_internacao_precricao');
        $this->db->where("internacao_id", $internacao_id);
        $this->db->where("data", $dataprescricao);
        $query = $this->db->get();
        $return = $query->result();

        $numero = count($return);

        if ($numero == 0) {
            $this->db->set('data', $dataprescricao);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao');
            $internacao_precricao_id = $this->db->insert_id();
        } else {
            $internacao_precricao_id = $return[0]->internacao_precricao_id;
        }

        if ($_POST['produto'] != "Selecione") {

            $this->db->set('etapas', $_POST['etapas']);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id = $this->db->insert_id();

            $i = 0;
            foreach ($_POST['produto'] as $produto) {
                $z = 0;
                $c = 0;
                $i++;
                foreach ($_POST['volume'] as $itemvolume) {
                    $c++;
                    if ($i == $c) {
                        $volume = $itemvolume;
                        break;
                    }
                }
                foreach ($_POST['vazao'] as $itemvazao) {
                    $z++;
                    if ($i == $z) {
                        $vazao = $itemvazao;
                        break;
                    }
                }

                $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id);
                $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                $this->db->set('internacao_id', $internacao_id);
                $this->db->set('etapas', $_POST['etapas']);
                $this->db->set('tipo', 'ENTERALEMERGENCIAL');
                if ($produto != "Selecione") {
                    $this->db->set('produto_id', $produto);
                }
                if ($volume != null) {
                    $this->db->set('volume', $volume);
                }
                if ($vazao != null) {
                    $this->db->set('vasao', $vazao);
                }
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_precricao_produto');
                $internacao_precricao_produto_id = $this->db->insert_id();
            }
        }

        if ($_POST['equipo'] != "Selecione") {

            $this->db->set('etapas', 1);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id_equipo = $this->db->insert_id();

            $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id_equipo);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('etapas', 1);
            $this->db->set('tipo', 'ENTERALEMERGENCIAL');
            $this->db->set('produto_id', $_POST['equipo']);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_produto');
        }
    }

    function repetirultimaprescicaoenteralnormal($internacao_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('internacao_precricao_id');
        $this->db->from('tb_internacao_precricao');
        $this->db->where("internacao_id", $internacao_id);
        $query = $this->db->get();
        $row = $query->last_row();

        $numero = count($row->internacao_precricao_id);
        if ($numero > 0) {
            $this->db->set('data', $dataprescricao);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao');
            $internacao_precricao_id = $this->db->insert_id();

            $this->db->select('internacao_precricao_etapa_id, etapas');
            $this->db->from('tb_internacao_precricao_etapa');
            $this->db->where("internacao_precricao_id", $row->internacao_precricao_id);
            $query = $this->db->get();
            $returno = $query->result();
            $numeroetapa = count($returno);

            if ($numeroetapa > 0) {
                foreach ($returno as $item) {
                    $this->db->set('etapas', $item->etapas);
                    $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_internacao_precricao_etapa');
                    $internacao_precricao_etapa_id = $this->db->insert_id();

                    $this->db->select('internacao_precricao_id, internacao_id, etapas, produto_id, volume, vasao');
                    $this->db->from('tb_internacao_precricao_produto');
                    $this->db->where("internacao_precricao_etapa_id", $item->internacao_precricao_etapa_id);
                    $query = $this->db->get();
                    $return = $query->result();
                    $numeroproduto = count($return);


                    if ($numeroproduto > 0) {
                        foreach ($return as $value) {
                            $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id);
                            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                            $this->db->set('internacao_id', $value->internacao_id);
                            $this->db->set('etapas', $value->etapas);
                            $this->db->set('tipo', 'ENTERALNORMAL');
                            if ($value->produto_id != "") {
                                $this->db->set('produto_id', $value->produto_id);
                            }
                            if ($value->volume != "") {
                                $this->db->set('volume', $value->volume);
                            }
                            if ($value->vasao != "") {
                                $this->db->set('vasao', $value->vasao);
                            }
                            $this->db->set('empresa_id', $empresa_id);
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_internacao_precricao_produto');
                        }
                    }
                }
            }
        }
    }

    function gravarmodelogrupo() {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('nome', $_POST['nome']);
            $this->db->set('texto', $_POST['texto']);
            $this->db->set('empresa_id', $empresa_id);
//            var_dump($_POST['internacao_modelo_grupo_id']); die;
            if ($_POST['internacao_modelo_grupo_id'] > 0) {
                $internacao_modelo_grupo_id = $_POST['internacao_modelo_grupo_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_modelo_grupo_id', $internacao_modelo_grupo_id);
                $this->db->update('tb_internacao_modelo_grupo');
            } else {

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_modelo_grupo');
                $internacao_modelo_grupo_id = $this->db->insert_id();
            }

            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluirmodelogrupo($internacao_modelo_grupo_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_modelo_grupo_id', $internacao_modelo_grupo_id);
            $this->db->update('tb_internacao_modelo_grupo');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarfichaquestionario() {

        try {
            if ($_POST['txtPacienteId'] == '') {


                $this->db->set('nome', $_POST['nome_paciente']);
                $this->db->set('sexo', $_POST['sexo']);
                $this->db->set('idade', $_POST['idade']);
                if ($_POST['municipio_id'] > 0) {
                    $this->db->set('municipio_id', $_POST['municipio_id']);
                }
                if ($_POST['convenio'] > 0) {
                    $this->db->set('convenio_id', $_POST['convenio']);
                }
                if ($_POST['nascimento'] != '') {
                    $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                }
                $this->db->insert('tb_paciente');
                $paciente_id = $this->db->insert_id();
            } else {
                $paciente_id = $_POST['txtPacienteId'];
//                die;
                $this->db->set('idade', $_POST['idade']);
                if ($_POST['municipio_id'] > 0) {
                    $this->db->set('municipio_id', $_POST['municipio_id']);
                }
                if ($_POST['convenio'] > 0) {
                    $this->db->set('convenio_id', $_POST['convenio']);
                }
                if ($_POST['nascimento'] != '') {
                    $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
                }
                $this->db->set('sexo', $_POST['sexo']);
                $this->db->set('nome', $_POST['nome_paciente']);
                $this->db->where('paciente_id', $paciente_id);
                $this->db->update('tb_paciente');
            }



            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');


            $this->db->set('nome', $_POST['nome_responsavel']);
            $this->db->set('grau_parentesco', $_POST['grau_parentesco']);
            $this->db->set('ocupacao_responsavel', $_POST['ocupacao']);
//            $this->db->set('grau_parentesco', $empresa_id);
            $this->db->set('paciente_id', $paciente_id);
            $tipo_dependencia_json = json_encode($_POST['tipo_dependencia']);
            // if ($_POST['tipo_dependencia'] > 0) {
                $this->db->set('tipo_dependencia', $tipo_dependencia_json);
            // }
            if ($_POST['idade_inicio'] > 0) {
//                echo 'asdad';
                $this->db->set('idade_inicio', $_POST['idade_inicio']);
            }
//            var_dump($_POST['idade_inicio']); die;

            $this->db->set('paciente_agressivo', $_POST['paciente_agressivo']);
            $this->db->set('aceita_tratamento', $_POST['aceita_tratamento']);
            if ($_POST['indicacao'] > 0) {
                $this->db->set('tomou_conhecimento', $_POST['indicacao']);
            }
            $this->db->set('plano_saude', $_POST['plano_saude']);
            $this->db->set('tratamento_anterior', $_POST['tratamento_anterior']);
            $this->db->set('telefone_contato', $_POST['telefone_contato']);
            if ($_POST['convenio'] > 0) {
                $this->db->set('convenio_id', $_POST['convenio']);
            }
            if ($_POST['municipio_id'] > 0) {
                $this->db->set('municipio_id', $_POST['municipio_id']);
            }

            $this->db->set('observacao', $_POST['observacao']);
            $this->db->set('grupo', $_POST['grupo']);

//            var_dump($_POST['internacao_ficha_questionario_id']); die;
            if ($_POST['internacao_ficha_questionario_id'] > 0) {
                $internacao_ficha_questionario_id = $_POST['internacao_ficha_questionario_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
                $this->db->update('tb_internacao_ficha_questionario');
            } else {

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_ficha_questionario');
                $internacao_ficha_questionario_id = $this->db->insert_id();
            }

            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluirfichaquestionario($internacao_ficha_questionario_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
            $this->db->update('tb_internacao_ficha_questionario');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function confirmarligacaofichaquestionario($internacao_ficha_questionario_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');
            // var_dump($_POST); die;
            if(isset($_POST['btnEnviar'])){
                $this->db->set('confirmado', 't');
            }else{
                $this->db->set('confirmado', 'f');
            }
            $this->db->set('observacao_ligacao', $_POST['txtobservacao']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
            $this->db->update('tb_internacao_ficha_questionario');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function desconfirmarligacaofichaquestionario($internacao_ficha_questionario_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('confirmado', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
            $this->db->update('tb_internacao_ficha_questionario');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function confirmaraprovacaofichaquestionario($internacao_ficha_questionario_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('aprovado', 't');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_ficha_questionario_id', $internacao_ficha_questionario_id);
            $this->db->update('tb_internacao_ficha_questionario');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravareditarimpressao($impressao_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('texto', $_POST['texto']);
            $this->db->set('impressao_id', $impressao_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_empresa_impressao_internacao_temp');
            $impressao_temp_id = $this->db->insert_id();


            return $impressao_temp_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravartipodependencia() {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('nome', $_POST['nome']);
//            var_dump($_POST['internacao_tipo_dependencia_id']); die;
            if ($_POST['internacao_tipo_dependencia_id'] > 0) {
                $internacao_tipo_dependencia_id = $_POST['internacao_tipo_dependencia_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_tipo_dependencia_id', $internacao_tipo_dependencia_id);
                $this->db->update('tb_internacao_tipo_dependencia');
            } else {

                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_tipo_dependencia');
                $internacao_tipo_dependencia_id = $this->db->insert_id();
            }

            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluirtipodependencia($internacao_tipo_dependencia_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
//            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_tipo_dependencia_id', $internacao_tipo_dependencia_id);
            $this->db->update('tb_internacao_tipo_dependencia');


            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarmovimentacao($paciente_id, $leito_id) {

        try {
            $this->db->set('leito_id', $_POST['leitoID']);
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('leito_id', $_POST['leitoID']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_ocupacao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                $internacao_ocupacao_id = $this->db->insert_id();

                $this->db->set('ativo', 'false');
                $this->db->where('internacao_leito_id', $_POST['leitoID']);
                $this->db->update('tb_internacao_leito');

                $this->db->set('ativo', 'true');
                $this->db->where('internacao_leito_id', $leito_id);
                $this->db->update('tb_internacao_leito');
            }
            return $internacao_ocupacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluiritemprescicao($item_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('ativo', 'false');
            $this->db->where('internacao_precricao_produto_id', $item_id);
            $this->db->update('tb_internacao_precricao_produto');
            return $item_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarprescricaofarmacia($internacao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('medicamento_id', $_POST['txtMedicamentoID']);
        $this->db->set('aprasamento', $_POST['aprasamento']);
        $this->db->set('dias', $_POST['dias']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('internacao_id', $internacao_id);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_prescricao');
    }

    function cancelarprescricaopaciente($internacao_prescricao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('ativo', 'f');
        $this->db->set('data_exclusao', $horario);
        $this->db->set('operador_exclusao', $operador_id);
        $this->db->where('internacao_prescricao_id', $internacao_prescricao_id);
        $this->db->update('tb_internacao_prescricao');

        $this->db->select('fs.internacao_prescricao_id, fs.farmacia_saida_id');
        $this->db->from('tb_farmacia_saida fs');
        $this->db->where('fs.internacao_prescricao_id', $internacao_prescricao_id);
//        $this->db->where('fs.ativo', 't');
//        $this->db->where('(fs.ativo = true OR fs.ativo is null)');
        $return = $this->db->get()->result();
//        var_dump($return); die;

        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_saida_id', $return[0]->farmacia_saida_id);
        $this->db->update('tb_farmacia_saida');


        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('farmacia_saida_id', $return[0]->farmacia_saida_id);
        $this->db->update('tb_farmacia_saldo');
    }

    function confirmarprescricaofarmacia($internacao_prescricao_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $quantidade_estoque = $_POST['quantidade_saida'] - $_POST['quantidade_ministrada'];

        $this->db->set('qtde_ministrada', $_POST['quantidade_ministrada']);
        $this->db->set('qtde_original', $_POST['quantidade_saida']);
        $this->db->set('qtde_volta', $quantidade_estoque);
        $this->db->set('confirmado', 't');
//        $this->db->set('aprasamento', $_POST['aprasamento']);
//        $this->db->set('dias', $_POST['dias']);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('internacao_prescricao_id', $internacao_prescricao_id);
        $this->db->update('tb_internacao_prescricao');
        if ($_POST['quantidade_ministrada'] < $_POST['quantidade_saida']) {
//            $quantidade_estoque = $_POST['quantidade_saida'] - $_POST['quantidade_ministrada'];
//            var_dump($_POST['quantidade_saida']); die;
            $this->db->set('quantidade', $_POST['quantidade_ministrada']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('farmacia_saida_id', $_POST['farmacia_saida_id']);
            $this->db->update('tb_farmacia_saida');

            $this->db->set('quantidade', -$_POST['quantidade_ministrada']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('farmacia_saida_id', $_POST['farmacia_saida_id']);
            $this->db->update('tb_farmacia_saldo');
        }
    }

    function listardadosreceituario($internacao_id) {
        $this->db->select('p.nome, 
                           pr.descricao_resumida as procedimento, 
                           i.solicitante, 
                           i.leito as sala, 
                           i.paciente_id, 
                           p.nascimento,
                           pr.procedimento_id');
        $this->db->from('tb_internacao i');
        $this->db->where("i.internacao_id = $internacao_id");
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id");
        $this->db->join('tb_procedimento pr', "pr.procedimento_id = i.procedimentosolicitado");
        $return = $this->db->get();
        return $return->result();
    }

    function listardadosinternacao($internacao_id) {
        $this->db->select('i.internacao_id,
                           i.solicitante, 
                           i.leito as sala, 
                           i.paciente_id, 
                           p.nascimento,
                           c.nome as convenio,
                           pc.convenio_id');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id", 'left');
        $this->db->join('tb_procedimento_convenio pc', "pc.procedimento_convenio_id = i.procedimento_convenio_id", 'left');
        $this->db->join('tb_convenio c', "c.convenio_id = pc.convenio_id", 'left');
        $this->db->where("i.internacao_id = $internacao_id");
//        $this->db->where("i.ativo", 't');

        $return = $this->db->get();
        return $return->result();
    }

    function listarevolucoes($internacao_id) {
        $this->db->select('p.nome, 
                           ie.internacao_evolucao_id, 
                           ie.conduta, 
                           ie.diagnostico, 
                           o.nome as operador,
                           ie.data_cadastro, 
                           p.nascimento');
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->join('tb_internacao i', "i.internacao_id = ie.internacao_id", 'left');
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id", 'left');
        $this->db->join('tb_operador o', "ie.operador_cadastro = o.operador_id", 'left');
        $this->db->where("ie.internacao_id = $internacao_id");
        $this->db->where("ie.ativo", 't');
        $this->db->orderby("ie.internacao_evolucao_id");
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentoexterno($internacao_id) {
        $this->db->select('p.nome, 
                           ie.internacao_procedimento_externo_id, 
                           ie.procedimento, 
                           ie.duracao, 
                           ie.data, 
                           o.nome as operador,
                           ie.data_cadastro, 
                           p.nascimento');
        $this->db->from('tb_internacao_procedimento_externo ie');
        $this->db->join('tb_internacao i', "i.internacao_id = ie.internacao_id", 'left');
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id", 'left');
        $this->db->join('tb_operador o', "ie.operador_cadastro = o.operador_id", 'left');
        $this->db->where("ie.internacao_id = $internacao_id");
        $this->db->where("ie.ativo", 't');
        $this->db->orderby("ie.internacao_procedimento_externo_id");
        $return = $this->db->get();
        return $return->result();
    }

    function editarevolucaointernacao($internacao_evolucao_id) {
        $this->db->select('p.nome, 
                           ie.internacao_evolucao_id, 
                           ie.conduta, 
                           ie.diagnostico, 
                           ie.data_cadastro, 
                           p.nascimento');
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->join('tb_internacao i', "i.internacao_id = ie.internacao_id", 'left');
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id", 'left');
        $this->db->where("ie.internacao_evolucao_id = $internacao_evolucao_id");
//        $this->db->where("ie.ativo", 't');
        $this->db->orderby("ie.internacao_evolucao_id");
        $return = $this->db->get();
        return $return->result();
    }

    function editarprocedimentoexternointernacao($internacao_procedimento_externo_id) {
        $this->db->select('p.nome, 
                           ie.internacao_procedimento_externo_id, 
                           ie.data, 
                           ie.duracao, 
                           ie.procedimento, 
                           ie.observacao, 
                           ie.data_cadastro, 
                           p.nascimento');
        $this->db->from('tb_internacao_procedimento_externo ie');
        $this->db->join('tb_internacao i', "i.internacao_id = ie.internacao_id", 'left');
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id", 'left');
        $this->db->where("ie.internacao_procedimento_externo_id = $internacao_procedimento_externo_id");
//        $this->db->where("ie.ativo", 't');
        $this->db->orderby("ie.internacao_procedimento_externo_id");
        $return = $this->db->get();
        return $return->result();
    }

    private function instanciar($emergencia_solicitacao_acolhimento_id) {
        if ($paciente_id != 0) {

            $this->db->select('tp.tipo_logradouro_id as codigo_logradouro,tp.descricao,p.*,c.nome as cidade_desc,c.municipio_id as cidade_cod,e.estado_id as uf_cod, e.nome as uf_desc');
            $this->db->from('tb_paciente p');
            $this->db->join('tb_municipio c', 'c.municipio_id = p.municipio_id', 'left');
            $this->db->join('tb_estado e', 'e.estado_id = p.uf_rg', 'left');
            $this->db->join('tb_tipo_logradouro tp', 'p.tipo_logradouro = tp.tipo_logradouro_id', 'left');
            $this->db->where("paciente_id", $paciente_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_paciente_id = $paciente_id;
            $this->_cpf = $return[0]->cpf;
            $this->_nome = $return[0]->nome;
            $this->_cns = $return[0]->cns;
            if (isset($return[0]->nascimento)) {
                $this->_nascimento = $return[0]->nascimento;
            }
            $this->_idade = $return[0]->idade;
            $this->_documento = $return[0]->rg;
            $this->_estado_id_expedidor = $return[0]->uf_rg;
            $this->_titulo_eleitor = $return[0]->titulo_eleitor;
            $this->_raca_cor = $return[0]->raca_cor;
            $this->_sexo = $return[0]->sexo;
            $this->_estado_civil = $return[0]->estado_civil_id;
            $this->_nomepai = $return[0]->nome_pai;
            $this->_nomemae = $return[0]->nome_mae;
            $this->_telMae = $return[0]->telefone_mae;
            $this->_telefone = $return[0]->telefone;
            $this->_tipoLogradouro = $return[0]->codigo_logradouro;
            $this->_numero = $return[0]->numero;
            $this->_rua = $return[0]->logradouro;
            $this->_bairro = $return[0]->bairro;
            $this->_cidade = $return[0]->municipio_id;
            $this->_cep = $return[0]->cep;
            $this->_observacao = $return[0]->observacao;
            $this->_complemento = $return[0]->complemento;
            $this->_estado_expedidor = $return[0]->uf_desc;
            $this->_estado_id_expedidor = $return[0]->uf_cod;
            $this->_cidade_nome = $return[0]->cidade_desc;
            $this->_data_emissao = $return[0]->data_emissao;
        }
    }

    function listaunidade() {
        $this->db->select(' internacao_unidade_id,
                            nome');
        $this->db->from('tb_internacao_unidade');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function usafarmacia() {
        $this->db->select(' empresa_id,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->where('farmacia', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisarunidade($unidade_id) {
        $this->db->select(' internacao_unidade_id,
                            nome');
        $this->db->from('tb_internacao_unidade');
        $this->db->where('internacao_unidade_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisarenfermaria($unidade_id) {
        $this->db->select(' internacao_enfermaria_id,
                            nome');
        $this->db->from('tb_internacao_enfermaria');
        $this->db->where('internacao_enfermaria_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisarindicaco($unidade_id) {
        $this->db->select('paciente_indicacao_id,
                            nome');
        $this->db->from('tb_paciente_indicacao');
        $this->db->where('paciente_indicacao_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisarconvenio($unidade_id) {
        $this->db->select('convenio_id,
                            nome');
        $this->db->from('tb_convenio');
        $this->db->where('convenio_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisartipodependencia($unidade_id) {
        $this->db->select('internacao_tipo_dependencia_id,
                            nome');
        $this->db->from('tb_internacao_tipo_dependencia');
        $this->db->where('internacao_tipo_dependencia_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisarcidade($unidade_id) {
        $this->db->select('municipio_id,
                            nome');
        $this->db->from('tb_municipio');
        $this->db->where('municipio_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listapacienteinternado($internacao_id) {
        $this->db->select(' p.nome as paciente,
                            p.paciente_id,
                            i.internacao_id,
                            il.nome as leito,
                            i.leito as leito_id');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id ');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        // $this->db->where('p.paciente_id', $paciente_id);
        $this->db->where('i.internacao_id', $internacao_id);
        // $this->db->where('i.leito = il.internacao_leito_id');
        // $this->db->where('il.ativo', 'f');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprodutosenteral($internacao_id) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_paciente p', 'p.convenio_id = pc.convenio_id ');
        $this->db->join('tb_internacao i', 'i.paciente_id = p.paciente_id ');
        $this->db->where('i.internacao_id', $internacao_id);
        $this->db->where('pt.grupo', 'ENTERAL');
        $this->db->where('pc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprodutosequipo($internacao_id) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_paciente p', 'p.convenio_id = pc.convenio_id ');
        $this->db->join('tb_internacao i', 'i.paciente_id = p.paciente_id ');
        $this->db->where('i.internacao_id', $internacao_id);
        $this->db->where('pt.grupo', 'EQUIPO');
        $this->db->where('pc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesenteral($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ', 'left');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ', 'left');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('ipp.tipo', 'ENTERALNORMAL');
        $this->db->where('ip.data', $data);
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesenteralemergencial($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ', 'left');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ', 'left');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('ipp.tipo', 'ENTERALEMERGENCIAL');
        $this->db->where('ip.data', $data);
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoespaciente($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ip.data,
                            ip.internacao_precricao_id,
                            ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('pt.grupo !=', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoespacienteequipo($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_id,
                            ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('pt.grupo', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesdata() {
        $data = date("Y-m-d");
        $this->db->select(' ip.data,
                            ip.internacao_precricao_id,
                            ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome,
                            p.nome as paciente');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->join('tb_internacao i', 'i.internacao_id = ip.internacao_id');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id');
        $this->db->where('ip.data >=', $_POST['txtdata_inicio']);
        $this->db->where('ip.data <=', $_POST['txtdata_fim']);
        $this->db->where('ipp.tipo', $_POST['tipo']);
        if ($_POST['unidade'] != 0) {
            $this->db->where('i.hospital_id', $_POST['unidade']);
        }
        $this->db->where('pt.grupo !=', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioprecadastro() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          p.nome as paciente,
                          p.idade,
                          ifq.nome as responsavel,
                          ifq.aceita_tratamento,
                          ifq.data_cadastro,
                          ifq.telefone_contato as telefone,
                          m.nome as cidade,
                          c.nome as convenio,
                          pi.nome as indicacao,
                          ifq.tipo_dependencia as dependencia,
                          ifq.confirmado,
                          ifq.aprovado,
                          ');
        $this->db->from('tb_internacao_ficha_questionario ifq');
        $this->db->join('tb_paciente p', 'p.paciente_id = ifq.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = ifq.convenio_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = ifq.municipio_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = ifq.tomou_conhecimento', 'left');
        // $this->db->join('tb_internacao_tipo_dependencia itd', 'itd.internacao_tipo_dependencia_id = ifq.tipo_dependencia', 'left');
        $this->db->where('ifq.ativo', 't');
        $this->db->where("ifq.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
        $this->db->where("ifq.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');


        if ($_POST['aceita_tratamento'] != '') {
            $this->db->where('ifq.aceita_tratamento', $_POST['aceita_tratamento']);
        }
        if ($_POST['indicacao'] > 0) {
            $this->db->where('ifq.tomou_conhecimento', $_POST['indicacao']);
        }
        if ($_POST['convenio'] != 0) {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('ifq.convenio_id', null);
            } else {
                $this->db->where('ifq.convenio_id', $_POST['convenio']);
            }
        }
        if ($_POST['cidade'] > 0) {

            $this->db->where('ifq.municipio_id', $_POST['cidade']);
        }
        // $post_dependencia = $_POST['tipo_dependencia'];
        // if ($_POST['tipo_dependencia'] > 0) {
        //     $this->db->where("position('$post_dependencia' in ifq.tipo_dependencia) > 0");
        // }
        // Filtro é feito na view agora porque é mais de um por campo e blá blá blá.
        if ($_POST['confirmado'] != '') {
            $this->db->where('ifq.confirmado', $_POST['confirmado']);
        }
        if ($_POST['aprovado'] != '') {
            $this->db->where('ifq.aprovado', $_POST['aprovado']);
        }

        $this->db->orderby('ifq.data_cadastro desc');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocensodiario() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          il.nome as leito,
                          il.condicao,
                          il.ativo,
                          ist.nome as status,
                          ist.color,
                          ROW_NUMBER() OVER (PARTITION BY il.internacao_leito_id) AS row_number, 
                          il.internacao_leito_id,
                          i.excluido as excluido_int,
                          i.ativo as ativo_int,
                          ie.nome as enfermaria,
                          ie.unidade_id,
                          iu.nome as unidade,
                          i.cid1solicitado as cid1,
                          i.data_internacao,
                          p.nome as paciente,
                          p.sexo,
                          p.nascimento,
                          p.idade,
                          pt.nome as procedimento,
                          
                          ');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao i', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_statusinternacao ist', 'ist.internacao_statusinternacao_id = i.internacao_statusinternacao_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('il.excluido', 'f');
        $this->db->where('ie.ativo', 't');
        $this->db->where('iu.ativo', 't');
        $this->db->where('(i.excluido = false OR i.excluido is null OR (i.excluido = true AND il.ativo = true))');
        $this->db->where('(i.ativo = true OR i.ativo is null OR (i.ativo = false AND il.ativo = true))');
        // Não dá pra fazer a verificação da existência da internação aqui, deve ser feito na view
        if ($_POST['unidade'] != '') {
            $this->db->where('ie.unidade_id', $_POST['unidade']);
        }
        if ($_POST['enfermaria'] != '') {
            $this->db->where('il.enfermaria_id', $_POST['enfermaria']);
        }
        if ($_POST['status_leito'] != '') {

            if ($_POST['status_leito'] == 'Vago') {
                $this->db->where('il.ativo', 't');
            } elseif ($_POST['status_leito'] == 'Ocupado') {
                $this->db->where('il.ativo', 'f');
            } else {
                $this->db->where('il.condicao', $_POST['status_leito']);
            }
        }

        $this->db->orderby('iu.internacao_unidade_id, ie.internacao_enfermaria_id, il.nome, p.paciente_id, i.data_internacao desc');
        $return = $this->db->get();
        return $return->result();
    }
    
    function relatoriounidadeleito() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          il.nome as leito,
                          il.condicao,
                          il.tipo as tipoleito,
                          il.ativo,
                          ie.nome as enfermaria,
                          ie.unidade_id,
                          ie.tipo as tipoenfermaria,
                          iu.nome as unidade                        
                          
                          ');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao i', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('il.excluido', 'f');
        $this->db->where('ie.ativo', 't');
        $this->db->where('iu.ativo', 't');
        $this->db->where('(i.excluido = false OR i.excluido is null)');
        $this->db->where('(i.ativo = true OR i.ativo is null)');

        if ($_POST['unidade'] != '') {
            $this->db->where('ie.unidade_id', $_POST['unidade']);
        }
        if ($_POST['enfermaria'] != '') {
            $this->db->where('il.enfermaria_id', $_POST['enfermaria']);
        }        

        $this->db->orderby('iu.internacao_unidade_id, ie.internacao_enfermaria_id, il.ativo, il.nome, i.data_internacao desc');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriointernacao() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          il.nome as leito,
                          il.condicao,
                          il.ativo,
                          ie.nome as enfermaria,
                          ie.unidade_id,
                          iu.nome as unidade,
                          i.cid1solicitado as cid1,
                          i.data_internacao,
                          p.nome as paciente,
                          p.sexo,
                          p.nascimento,
                          p.idade,
                          c.nome as convenio,
                          pt.nome as procedimento,
                          
                          ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('i.ativo = true');
        $this->db->where('i.excluido = false');
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00';

        $this->db->where("(i.data_internacao >= '$data_inicio' OR cast(i.data_internacao AS date) + 
        cast((Select sum(quantidade) from ponto.tb_internacao_procedimentos
         where internacao_id = i.internacao_id and ativo = true) as integer) >= '$data_inicio')");
//        $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) );
        $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != '') {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('c.convenio_id', null);
            } else {
                $this->db->where('c.convenio_id', $_POST['convenio']);
            }
        }


        $this->db->orderby('iu.internacao_unidade_id, ie.internacao_enfermaria_id, il.ativo, il.nome, i.data_internacao desc');
        $return = $this->db->get();
        return $return->result();
    }
    
    function relatoriointernacaosituacao() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          il.nome as leito,
                          il.condicao,
                          il.ativo,
                          ie.nome as enfermaria,
                          ie.unidade_id,
                          iu.nome as unidade,
                          i.ativo as situacao,
                          i.cid1solicitado as cid1,
                          i.data_internacao,
                          p.nome as paciente,
                          p.sexo,
                          p.nascimento,
                          p.idade,
                          c.nome as convenio,
                          pt.nome as procedimento,
                          
                          ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
//        $this->db->where('i.ativo = true');
        $this->db->where('i.excluido = false');
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00';

        $this->db->where("(i.data_internacao >= '$data_inicio' OR cast(i.data_internacao AS date) + 
        cast((Select sum(quantidade) from ponto.tb_internacao_procedimentos
         where internacao_id = i.internacao_id and ativo = true) as integer) >= '$data_inicio')");
//        $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) );
        $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != '') {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('c.convenio_id', null);
            } else {
                $this->db->where('c.convenio_id', $_POST['convenio']);
            }
        }


        $this->db->orderby('iu.internacao_unidade_id, ie.internacao_enfermaria_id, il.ativo, il.nome, i.data_internacao desc');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriosaidainternacao() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          il.nome as leito,
                          il.condicao,
                          il.ativo,
                          ie.nome as enfermaria,
                          ie.unidade_id,
                          iu.nome as unidade,
                          i.cid1solicitado as cid1,
                          i.data_internacao,
                          i.data_saida,
                          p.nome as paciente,
                          p.sexo,
                          p.nascimento,
                          p.idade,
                          c.nome as convenio,
                          pt.nome as procedimento,
                          
                          ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('i.ativo = false');
        $this->db->where('i.excluido = false');
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00';

        $this->db->where("(i.data_internacao >= '$data_inicio' OR cast(i.data_internacao AS date) + 
        cast((Select sum(quantidade) from ponto.tb_internacao_procedimentos
         where internacao_id = i.internacao_id and ativo = true) as integer) >= '$data_inicio')");
//        $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) );
        $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != '') {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('c.convenio_id', null);
            } else {
                $this->db->where('c.convenio_id', $_POST['convenio']);
            }
        }


        $this->db->orderby('iu.internacao_unidade_id, ie.internacao_enfermaria_id, il.ativo, il.nome, i.data_internacao desc');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriointernacaofaturamento() {
        $data = date("Y-m-d");
        $this->db->select(' 
                          il.nome as leito,
                          il.condicao,
                          il.ativo,
                          ie.nome as enfermaria,
                          ie.unidade_id,
                          iu.nome as unidade,
                          i.cid1solicitado as cid1,
                          i.data_internacao,
                          i.data_saida,
                          i.valor_total,
                          p.nome as paciente,
                          p.sexo,
                          p.nascimento,
                          p.idade,
                          c.nome as convenio,
                          pt.nome as procedimento,
                          
                          ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'p.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
//        $this->db->where('i.ativo = true');
        $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00');
        $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != '') {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('c.convenio_id', null);
            } else {
                $this->db->where('c.convenio_id', $_POST['convenio']);
            }
        }


        $this->db->orderby('iu.internacao_unidade_id, ie.internacao_enfermaria_id, il.ativo, il.nome, i.data_internacao desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarcarregarinternacao($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' 
                          i.*,
                          il.nome as leito,
                          il.internacao_leito_id,
                          p.nome as paciente,
                          p.sexo,
                          p.nascimento,
                          ie.nome as enfermaria,
                          iu.nome as unidade,
                          cid.co_cid,
                          cid.no_cid,
                          cid2.co_cid as co_cid2,
                          cid2.no_cid as no_cid2,
                          pt.nome as procedimento,
                          pt.procedimento_tuss_id,
                          pc.procedimento_convenio_id,
                          pc.convenio_id,
                          m.nome as cidade_responsavel,
                          
                          ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_municipio m', 'i.municipio_responsavel_id = m.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_cid cid2', 'cid2.co_cid = i.cid2solicitado', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("i.internacao_id ", $internacao_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesequipodata() {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->join('tb_internacao i', 'i.internacao_id = ip.internacao_id');
        $this->db->where('ip.data >=', $_POST['txtdata_inicio']);
        $this->db->where('ip.data <=', $_POST['txtdata_fim']);
        $this->db->where('ipp.tipo', $_POST['tipo']);
        if ($_POST['unidade'] != 0) {
            $this->db->where('i.hospital_id', $_POST['unidade']);
        }
        $this->db->where('pt.grupo', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitointarnacao($unidade_id) {
        $this->db->select(' il.internacao_leito_id,
                            il.nome');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('il.ativo', 't');
        $this->db->where('il.excluido', 'f');
        $this->db->where('il.condicao', 'Normal');
        $this->db->where('iu.internacao_unidade_id', $unidade_id);
        $this->db->orderby('ie.internacao_enfermaria_id, il.internacao_leito_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitointarnacao2($unidade_id) {
        $this->db->select(' il.internacao_leito_id,
                            il.nome as leito,
                            ie.nome as enfermaria');
        $this->db->from('tb_internacao_leito il, tb_internacao_enfermaria ie');
        $this->db->where('ie.internacao_enfermaria_id = il.enfermaria_id');
        $this->db->where('il.ativo', 't');
        $this->db->where('il.excluido', 'f');
        $this->db->where('il.condicao', 'Normal');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('iu.internacao_unidade_id', $unidade_id);
        $this->db->orderby('ie.internacao_enfermaria_id, il.internacao_leito_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listapacienteunidade($unidade) {
        $this->db->select(' p.nome as paciente,
                            p.paciente_id,
                            il.internacao_leito_id as leito_id,
                            il.nome as leito,
                            ie.nome as enfermaria');
        $this->db->from('tb_paciente p, tb_internacao i, tb_internacao_leito il, tb_internacao_enfermaria ie');
        $this->db->where('i.paciente_id = p.paciente_id');
        $this->db->where('i.leito = il.internacao_leito_id');
        $this->db->where('il.ativo', 'f');
        $this->db->where('i.ativo', 't');
        $this->db->where('i.excluido', 'f');
        $this->db->where('il.excluido', 'f');
        $this->db->where('ie.internacao_enfermaria_id = il.enfermaria_id');
        $this->db->where('ie.unidade_id', $unidade);
        $this->db->orderby('ie.internacao_enfermaria_id, il.internacao_leito_id');

        $return = $this->db->get();
        return $return->result();
    }

    function listaunidadecondicao($condicao) {
        $sql = "SELECT DISTINCT iu.nome,
                       iu.internacao_unidade_id
                FROM ponto.tb_internacao_leito il, ponto.tb_internacao_enfermaria ie, ponto.tb_internacao_unidade iu
                WHERE ie.internacao_enfermaria_id = il.enfermaria_id
                AND iu.internacao_unidade_id = ie.unidade_id ";
        if ($condicao == "Ocupado") {
            $sql .= "AND il.ativo = 'f'";
        } else {
            $sql .= "AND il.ativo = 't'
                AND il.condicao = '$condicao'";
        }
        $return = $this->db->query($sql);
        return $return->result();
    }

    function listaunidadetransferencia($condicao = '') {
        $this->db->select('iu.internacao_unidade_id,
                           iu.nome as unidade');
        $this->db->from('tb_internacao_unidade iu');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaenfermariatransferencia() {
        $this->db->select('ie.internacao_enfermaria_id,
                           ie.nome as enfermaria,
                           ie.unidade_id');
        $this->db->from('tb_internacao_enfermaria ie');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitotransferencia() {
        $this->db->select('il.internacao_leito_id as leito_id,
                           il.nome as leito,
                           il.enfermaria_id');
        $this->db->from('tb_internacao_leito il');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function pegaidpacientepermuta($leito_id) {
        //pegando o id do paciente permutado
        $this->db->select('i.paciente_id');
        $this->db->from('tb_internacao i');
        $this->db->where('i.leito', $leito_id);
        $this->db->where('i.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function permutapacientes() {
        //trocando os leitos na tabela internacao
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('i.internacao_id');
        $this->db->from('tb_internacao i');
//        $this->db->where('i.leito',  $_POST['leito_troca']);
        $this->db->where('i.paciente_id', $_POST['paciente_id_selecionado']);
        $this->db->where('i.ativo', 't');
        $return1 = $this->db->get()->result();
        $internacao_id1 = $return1[0]->internacao_id;

        $this->db->set('leito', $_POST['leito_troca']);
        $this->db->where('internacao_id', $internacao_id1);
        $this->db->update('tb_internacao');


        $this->db->select('i.internacao_id');
        $this->db->from('tb_internacao i');
//        $this->db->where('i.leito',  $_POST['leito_troca']);
        $this->db->where('i.paciente_id', $_POST['id_paciente_troca'][0]->paciente_id);
        $this->db->where('i.ativo', 't');
        $return2 = $this->db->get()->result();
        $internacao_id2 = $return2[0]->internacao_id;


        $this->db->set('leito', $_POST['leito_id_selecionado']);
        $this->db->where('internacao_id', $internacao_id2);
        $this->db->update('tb_internacao');
        // Inserindo na tabela as informações de alteração de leito do paciente 1 (O paciente cujo os dados vem carregados)
        $this->db->set('internacao_id', $internacao_id1);
        $this->db->set('leito_id', $_POST['leito_id_selecionado']);
        $this->db->set('tipo', 'SAIDA');
        $this->db->set('status', 'PERMUTA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');

        $this->db->set('internacao_id', $internacao_id1);
        $this->db->set('leito_id', $_POST['leito_troca']);
        $this->db->set('tipo', 'ENTRADA');
        $this->db->set('status', 'PERMUTA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');
        // Inserindo na tabela a saida e a entrada do paciente 2 (O que foi escolhido no select)
        $this->db->set('internacao_id', $internacao_id2);
        $this->db->set('leito_id', $_POST['leito_troca']);
        $this->db->set('tipo', 'SAIDA');
        $this->db->set('status', 'PERMUTA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');

        $this->db->set('internacao_id', $internacao_id2);
        $this->db->set('leito_id', $_POST['leito_id_selecionado']);
        $this->db->set('tipo', 'ENTRADA');
        $this->db->set('status', 'PERMUTA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');

        //atualizando a tabela ocupacao
        $this->db->set('ocupado', 'f');
        $this->db->where('paciente_id', $_POST['paciente_id_selecionado']);
        $this->db->where('leito_id', $_POST['leito_id_selecionado']);
        $this->db->update('tb_internacao_ocupacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
        $this->db->set('ocupado', 'f');
        $this->db->where('paciente_id', $_POST['id_paciente_troca'][0]->paciente_id);
        $this->db->where('leito_id', $_POST['leito_troca']);
        $this->db->update('tb_internacao_ocupacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }

        //inserindo na tabela ocupacao
        try {


            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('paciente_id', $_POST['paciente_id_selecionado']);
            $this->db->set('leito_id', $_POST['leito_troca']);
            $this->db->set('ocupado', 't');
            $this->db->insert('tb_internacao_ocupacao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                $this->db->insert_id();
            }

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('paciente_id', $_POST['id_paciente_troca'][0]->paciente_id);
            $this->db->set('leito_id', $_POST['leito_id_selecionado']);
            $this->db->set('ocupado', 't');
            $this->db->insert('tb_internacao_ocupacao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                $this->db->insert_id();
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function transferirpacienteleito() {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('i.internacao_id');
        $this->db->from('tb_internacao i');
//        $this->db->where('i.leito',  $_POST['leito_troca']);
        $this->db->where('i.paciente_id', $_POST['paciente_id']);
        $this->db->where('i.ativo', 't');
        $return1 = $this->db->get()->result();
        $internacao_id = $return1[0]->internacao_id;

        // Inserindo na tabela a saida e a entrada do paciente 2 (O que foi escolhido no select)
        $this->db->set('internacao_id', $internacao_id);
        $this->db->set('leito_id', $_POST['leito_id']);
        $this->db->set('tipo', 'SAIDA');
        $this->db->set('status', 'TRANSFERENCIA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');

        $this->db->set('internacao_id', $internacao_id);
        $this->db->set('leito_id', $_POST['novo_leito']);
        $this->db->set('tipo', 'ENTRADA');
        $this->db->set('status', 'TRANSFERENCIA');
        $this->db->set('data', $horario);
        $this->db->set('operador_movimentacao', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_leito_movimentacao');

        //atualizando o leito na tabela internacao e ocupacao
        $this->db->set('leito', $_POST['novo_leito']);
        $this->db->where('internacao_id', $internacao_id);
        $this->db->update('tb_internacao');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }

        $this->db->set('ocupado', 'f');
        $this->db->where('paciente_id', $_POST['paciente_id']);
        $this->db->where('leito_id', $_POST['leito_id']);
        $this->db->update('tb_internacao_ocupacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }


        //inserindo na tabela ocupacao
        try {


            if ($_POST['internacao_unidade_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('paciente_id', $_POST['paciente_id']);
                $this->db->set('leito_id', $_POST['novo_leito']);
                $this->db->set('ocupado', 't');
                $this->db->insert('tb_internacao_ocupacao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else {
                    $internacao_unidade_id = $this->db->insert_id();
                }
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarreceituariointernacao($internacao_id) {
        try {

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('texto', $_POST['laudo']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
            $this->db->set('laudo_id', $internacao_id);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('tipo', 'NORMAL');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_receituario');


            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function atualizaleitotranferencia($leito_id, $novo_leito) {
        //setando o antigo leito para true
        $this->db->set('ativo', 'true');
        $this->db->where('internacao_leito_id', $leito_id);
        $this->db->update('tb_internacao_leito');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
        //setando o atual leito para false
        $this->db->set('ativo', 'false');
        $this->db->where('internacao_leito_id', $novo_leito);
        $this->db->update('tb_internacao_leito');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
    }

    function buscaPaciente($pacienteId) {

        $this->db->from('tb_paciente')
                ->select('nome');
        $this->db->where('paciente_id', $pacienteId);
        return $this->db;
    }

    function listar($args = array()) {
        $this->db->select(' i.internacao_id,
                            i.paciente_id,
                            p.nome,
                            i.data_internacao,
                            i.data_saida');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ');
        $this->db->where('i.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
                $this->db->orwhere('i.paciente_id', $args['nome']);
            }
        }
        return $this->db;
    }

    function listarsaida($args = array()) {
        $this->db->select(' i.internacao_id,
                            i.paciente_id,
                            p.nome,
                            i.data_internacao,
                            i.data_saida');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ');
        $this->db->where('i.ativo', 'f');
        $this->db->where('i.excluido', 'f');
        if ($args) {
//            if (isset($args['nome']) && strlen($args['nome']) > 0) {
//                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
////                $this->db->orwhere('i.paciente_id', $args['nome']);
//                $this->db->orwhere('p.nome', $args['nome']);
//            }

            if (isset($args['data_inicio']) && strlen($args['data_inicio']) > 0) {
                $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $args['data_inicio']))) . ' 00:00:00');
            }
            if (isset($args['data_fim']) && strlen($args['data_fim']) > 0) {
                $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $args['data_fim']))) . ' 23:59:59');
            }
            if (isset($args['unidade']) && strlen($args['unidade']) > 0) {
                $this->db->where('iu.internacao_unidade_id', $args['unidade']);
//                $this->db->orwhere('i.paciente_id', $args['nome']);
            }
            if (isset($args['enfermaria']) && strlen($args['enfermaria']) > 0) {
                $this->db->where('ie.internacao_enfermaria_id', $args['enfermaria']);
//                $this->db->orwhere('i.paciente_id', $args['nome']);
            }

            if (isset($args['leito']) && strlen($args['leito']) > 0) {
                $this->db->where('il.internacao_leito_id', $args['leito']);
//                $this->db->orwhere('i.paciente_id', $args['nome']);
            }
            if (isset($args['medico_responsavel']) && strlen($args['medico_responsavel']) > 0) {
                $this->db->where('i.medico_id', $args['medico_responsavel']);
//                $this->db->orwhere('i.paciente_id', $args['nome']);
            }

            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
//                $this->db->orwhere('i.paciente_id', $args['nome']);
            }
        }
        return $this->db;
    }

    function retornarinternacaopaciente($internacao_id) {

        $this->db->select('i.internacao_id,
                           p.nome as paciente,
                           m.nome as motivosaida,
                           i.motivo_saida,
                           i.hospital_transferencia,
                           m.internacao_motivosaida_id,
                           p.paciente_id,
                           i.data_internacao,
                           i.observacao_saida,
                           i.leito,
                           il.ativo as leito_ativo,
                           i.data_saida,
                           il.nome as leito_nome,
                           iu.nome as unidade,
                           ie.nome as enfermaria,
                           o.nome as medico_internacao,
                           o2.nome as medico_saida,
                           p.sexo,
                           p.nascimento');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->join('tb_operador o2', 'o2.operador_id = i.medico_saida', 'left');
        $this->db->join('tb_internacao_motivosaida m', 'm.internacao_motivosaida_id = i.motivo_saida', 'left');
        $this->db->where('i.internacao_id', $internacao_id);
//        $this->db->where('p.paciente_id = i.paciente_id');
//        $this->db->where('o.operador_id = i.medico_id');
        // $this->db->where('m.internacao_motivosaida_id = i.motivo_saida ');

        $return = $this->db->get();
        return $return->result();
    }

    function listarinternacao($parametro) {
        $this->db->select('p.descricao,
                           cid.no_cid as nomecid,
                           cid.co_cid as codcid,
                           i.data_internacao,
                           o.nome as medico,
                           i.procedimentosolicitado,
                           i.estado');
        $this->db->from('tb_internacao i ');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado');
        $this->db->join('tb_procedimento p', 'p.procedimento = i.procedimentosolicitado');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id');
        $this->db->where('i.ativo', 't');
        if ($parametro != null) {
            $this->db->where('paciente_id', $parametro);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarinternacaolista($args = array()) {
        $this->db->select('pt.nome as procedimento,
                           p.nome as paciente,

                           i.data_internacao,
                           o.nome as medico,
                           il.nome as leito,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           il.internacao_leito_id,
                           i.internacao_id,
                           i.paciente_id,
                           i.procedimentosolicitado,
                           i.estado');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
//        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->where('i.excluido', 'f');
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('i.ativo', $args['situacao']);
        } else {
            $this->db->where('i.ativo', 't');
        }

        if (isset($args['data_inicio']) && strlen($args['data_inicio']) > 0) {
            $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $args['data_inicio']))) . ' 00:00:00');
        }
        if (isset($args['data_fim']) && strlen($args['data_fim']) > 0) {
            $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $args['data_fim']))) . ' 23:59:59');
        }



        if (isset($args['unidade']) && strlen($args['unidade']) > 0) {
            $this->db->where('iu.internacao_unidade_id', $args['unidade']);
//                $this->db->orwhere('i.paciente_id', $args['nome']);
        }
        if (isset($args['enfermaria']) && strlen($args['enfermaria']) > 0) {
            $this->db->where('ie.internacao_enfermaria_id', $args['enfermaria']);
//                $this->db->orwhere('i.paciente_id', $args['nome']);
        }

        if (isset($args['leito']) && strlen($args['leito']) > 0) {
            $this->db->where('il.internacao_leito_id', $args['leito']);
//                $this->db->orwhere('i.paciente_id', $args['nome']);
        }
        if (isset($args['medico_responsavel']) && strlen($args['medico_responsavel']) > 0) {
            $this->db->where('i.medico_id', $args['medico_responsavel']);
//                $this->db->orwhere('i.paciente_id', $args['nome']);
        }

        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
//                $this->db->orwhere('i.paciente_id', $args['nome']);
        }

        return $this->db;
    }

    function listarguiafaturamentomanualinternacao($args = array()) {
        $this->db->select('pt.nome as procedimento,
                           pt.codigo,
                           pt.qtde,
                           p.nome as paciente,
                           c.nome as convenio,
                           i.valor_total,
                           i.faturado,
                           i.data_internacao,
                           o.nome as medico,
                           il.nome as leito,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           il.internacao_leito_id,
                           i.internacao_id,
                           i.paciente_id,
                           i.procedimentosolicitado,
                           i.estado');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
//        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');

        $this->db->where("i.data_internacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('i.excluido', 'false');
//        $this->db->where('c.dinheiro', 'false');

        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        return $this->db->get()->result();
    }

    function listarguiafaturamentomanualinternacaoconvenio($args = array()) {
        $this->db->select('pt.nome as procedimento,
                           pt.codigo,
                           pt.qtde,
                           p.nome as paciente,
                           c.nome as convenio,
                           i.valor_total,
                           i.faturado,
                           i.data_internacao,
                           o.nome as medico,
                           
                           (Select sum(ip.valor_total) as valor_total_sum
                           from ponto.tb_internacao_procedimentos ip
                           where ip.internacao_id = i.internacao_id
                           and ip.ativo = true) as valor_total_sum, 
                           
                           (Select count(ip.valor_total) as contador_sum
                           from ponto.tb_internacao_procedimentos ip
                           where ip.internacao_id = i.internacao_id
                           and ip.ativo = true) as contador_sum, 
                           
                           (Select count(ip.valor_total)
                           from ponto.tb_internacao_procedimentos ip
                           where ip.internacao_id = i.internacao_id
                           and ip.ativo = true and faturado = true) as contador_faturado_sum, 
                           
                           (Select sum(ip.valor_total)
                           from ponto.tb_internacao_procedimentos ip
                           where ip.internacao_id = i.internacao_id
                           and ip.ativo = true and faturado = false) as valor_naofaturado_sum, 
                           
                           (Select sum(ip.valor_total)
                           from ponto.tb_internacao_procedimentos ip
                           where ip.internacao_id = i.internacao_id
                           and ip.ativo = true and faturado = true) as valor_faturado_sum, 
                           
                           (Select count(ip.valor_total)
                           from ponto.tb_internacao_procedimentos ip
                           where ip.internacao_id = i.internacao_id
                           and ip.ativo = true and financeiro = true) as contador_financeiro, 
                           il.nome as leito,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           il.internacao_leito_id,
                           i.internacao_id,
                           i.paciente_id,
                           i.procedimentosolicitado,
                           i.estado');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
//        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');

        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));

        $this->db->where("(i.data_internacao >= '$data_inicio' OR cast(i.data_internacao AS date) + 
cast((Select sum(quantidade) from ponto.tb_internacao_procedimentos
 where internacao_id = i.internacao_id and ativo = true) as integer) >= '$data_inicio')");

        $this->db->where("i.data_internacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->where('i.excluido', 'false');
        $this->db->where('c.dinheiro', 'false');

        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        if (isset($_POST['convenio']) && $_POST['convenio'] != "") {
            $this->db->where('pc.convenio_id', $_POST['convenio']);
        }
        $this->db->orderby('i.data_internacao');
        return $this->db->get()->result();
    }

    function internacaoimpressaomodelo($internacao_id) {
        $this->db->select('pt.nome as procedimento,
                           p.nome as paciente,
                           p.convenionumero,
                           p.sexo,
                           p.nascimento,
                           p.rg,
                           p.cpf,
                           c.nome as convenio,
                           p.nome as paciente,
                           cid.no_cid as nomecid,
                           cid.co_cid as codcid,
                           cid2.no_cid as nomecid2,
                           cid2.co_cid as codcid2,
                           i.data_internacao,
                           o.nome as medico,
                           o.conselho,
                           m.nome as municipio,
                           m.codigo_ibge,
                           il.nome as leito_nome,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           i.*
                           ');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_internacao_leito il', 'i.leito = il.internacao_leito_id', 'left');
        $this->db->join('tb_internacao_enfermaria ie', 'il.enfermaria_id = ie.internacao_enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'ie.unidade_id = iu.internacao_unidade_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->join('tb_cid cid2', 'cid2.co_cid = i.cid2solicitado', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id', 'left');
        $this->db->where('i.internacao_id', $internacao_id);


        $return = $this->db->get();
        return $return->result();
    }

    function listarmodeloimpressaointernacao($empresa_impressao_cabecalho_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_internacao_id, ei.nome as nome_internacao,ei.texto,ei.adicional_cabecalho, ei.cabecalho,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_internacao ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_impressao_internacao_id', $empresa_impressao_cabecalho_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarmodeloimpressaointernacaotemp($impressao_temp_id) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.*');
        $this->db->from('tb_empresa_impressao_internacao_temp ei');
        $this->db->where('ei.empresa_impressao_internacao_temp_id', $impressao_temp_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get()->result();

        return $return[0]->texto;
    }

    function listarleitosinternacao($parametro) {
        $this->db->select('io.leito_id,
                           io.data_cadastro,
                           io.operador_cadastro,
                           io.internacao_ocupacao_id,
                           il.nome as leito,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           o.nome as operador');
        $this->db->from('tb_internacao_ocupacao io');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = io.leito_id');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->join('tb_operador o', 'o.operador_id = io.operador_cadastro');
        $this->db->where('paciente_id', $parametro);
        $this->db->orderby('io.data_cadastro');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleito($args = array()) {
        $this->db->select(' il.internacao_leito_id,
                            il.nome,
                            ienome as enfermaria,
                            iu.nome as unidade,
                            il.tipo');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id', 'left');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ', 'left');
        $this->db->where('ie.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('il.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('ie.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('iu.nome ilike', "%" . $args['nome'] . "%");
            }
        }
        return $this->db;
    }

    function listaprocedimentoautocomplete($parametro = null) {
        $this->db->select(' procedimento,
                            descricao,
                            procedimento_id');
        $this->db->from('tb_procedimento');
        if ($parametro != null) {
            $this->db->where('descricao ilike', "%" . $parametro . "%");
            $this->db->orwhere('procedimento ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemedicamentoprescricao($parametro = null) {
        $this->db->select('farmacia_produto_id,
                           descricao');
        $this->db->from('tb_farmacia_produto');
        if ($parametro != null) {
            $this->db->where('descricao ilike', "%" . $parametro . "%");
        }
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listacidautocomplete($parametro = null) {
        $this->db->select(' co_cid,
                            no_cid');
        $this->db->from('tb_cid');
        if ($parametro != null) {
            $this->db->where('no_cid ilike', "%" . $parametro . "%");
            $this->db->orwhere('co_cid ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listamedicamentointernacao($internacao_id) {
        $this->db->select(' ip.dias,
                            ip.aprasamento,
                            ip.confirmado,
                            ip.qtde_ministrada,
                            pc.convenio_id,
                            fp.procedimento_tuss_id as procedimento_farmacia,
                            ip.internacao_prescricao_id,
                            fp.descricao');
        $this->db->from('tb_internacao_prescricao ip');
        $this->db->join('tb_internacao i', 'i.internacao_id = ip.internacao_id');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = i.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_farmacia_produto fp', 'fp.farmacia_produto_id = ip.medicamento_id');
        $this->db->where('ip.ativo', 'true');
        $this->db->where('ip.internacao_id', $internacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaconveniomedicamento($convenio_id, $procedimento_tuss_id) {
        $this->db->select('pc.convenio_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->where('pc.ativo', 'true');
        $this->db->where('pc.procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->where('pc.convenio_id', $convenio_id);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarprescricaopaciente($internacao_prescricao_id) {
        $this->db->select(' ip.dias,
                            ip.aprasamento,
                            fs.farmacia_saida_id,
                            fs.quantidade,
                            ip.internacao_prescricao_id,
                            fp.descricao');
        $this->db->from('tb_internacao_prescricao ip');
        $this->db->join('tb_farmacia_produto fp', 'fp.farmacia_produto_id = ip.medicamento_id');
        $this->db->join('tb_farmacia_saida fs', 'fs.internacao_prescricao_id = ip.internacao_prescricao_id');
        $this->db->where('ip.ativo', 'true');
        $this->db->where('fs.ativo', 'true');
        $this->db->where('fs.internacao_prescricao_id', $internacao_prescricao_id);
        $this->db->orderby('ip.internacao_prescricao_id');
        $return = $this->db->get();
        return $return->result();
    }

    function verificainternacao($paciente_id) {
        $this->db->select();
        $this->db->from('tb_internacao');
        $this->db->where("ativo", 'true');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function internacaoalta($internacao_id) {
        $this->db->set('ativo', 'false');
        $this->db->where('internacao_id', $internacao_id);
        $this->db->update('tb_internacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
    }

}

?>
