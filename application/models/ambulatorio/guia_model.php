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
                            telefone');
        $this->db->from('tb_paciente');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->get();
        return $return->result();
    }
    
    function preencherdetalhamento($aso_id) {

        $this->db->select('detalhamento_nr');
        $this->db->from('tb_cadastro_aso ca');
        $this->db->where('ca.cadastro_aso_id', $aso_id);        
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarempresamodelo() {

        $this->db->select('convenio_id');
        $this->db->from('tb_convenio');
        $this->db->where("padrao_particular", 'TRUE');
        $this->db->where("ativo", 'TRUE');
        $return = $this->db->get();
        return $return->result();
    }

    function procedimentocirurgicovalor($agenda_exames_id) {

        $this->db->select('valor_total,
                            agenda_exames_id');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listargruposrelatorioretorno() {
        $this->db->select('ambulatorio_grupo_id,
                            nome');
        $this->db->from('tb_ambulatorio_grupo');
        $this->db->where('nome !=', "AGRUPADOR");
        $this->db->where('nome !=', "RETORNO");
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listargruposrelatorioorcamento() {
        $this->db->select('ambulatorio_grupo_id,
                            nome');
        $this->db->from('tb_ambulatorio_grupo');
        $this->db->where('nome !=', "AGRUPADOR");
        $this->db->where('nome !=', "RETORNO");
        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function gravarprocedimentocirurgicovalor($agenda_exames_id) {
//        var_dump($_POST['valor']); die;
        $this->db->set('valor', str_replace(',', '.', $_POST['valor']));
        $this->db->set('valor_total', str_replace(',', '.', $_POST['valor']));
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
        return 1;
    }

    function listaraso($tipo) {
        $this->db->select('ca.*            ');
        $this->db->from('tb_cadastro_aso ca');
        $this->db->where('tipo', $tipo);

        $return = $this->db->get();
        return $return->result();
    }

    function listaraso2() {
        $this->db->select('ca.*            ');
        $this->db->from('tb_cadastro_aso ca');
//        $this->db->where('tipo', $tipo);

        $return = $this->db->get();
        return $return->result();
    }

    function listarfuncaoaso($nomefuncao) {
        $this->db->select('fu.descricao_funcao');
        $this->db->from('tb_aso_funcao fu');
        $this->db->where('aso_funcao_id', $nomefuncao);

        $return = $this->db->get();
        return $return->result();
    }

    function relatorioaso() {
//        var_dump($_POST);die;
        $data = date("Y-m-d");
        $this->db->select(' 
                          ca.*,
                          p.nome as paciente,
                          c.nome as convenio
                                                   
                          ');
        $this->db->from('tb_cadastro_aso ca');
        $this->db->join('tb_paciente p', 'p.paciente_id = ca.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'ca.convenio_id = c.convenio_id', 'left');

        $this->db->where('ca.ativo = true');

        if ($_POST['tipo'] != '') {
            $this->db->where('ca.tipo', $_POST['tipo']);
        }

        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00';

        $this->db->where("ca.data_realizacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ca.data_realizacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != '') {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('c.convenio_id', null);
            } else {
                $this->db->where('c.convenio_id', $_POST['convenio']);
            }
        }
        $this->db->orderby("ca.tipo, ca.data_realizacao");
        $return = $this->db->get();
        return $return->result();
    }
    
    function relatoriocadastroaso() {
//        var_dump($_POST);die;
        $data = date("Y-m-d");
        $this->db->select(' 
                          ca.*,
                          p.nome as paciente,
                          c.nome as convenio
                                                   
                          ');
        $this->db->from('tb_cadastro_aso ca');
        $this->db->join('tb_paciente p', 'p.paciente_id = ca.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'ca.convenio_id = c.convenio_id', 'left');

        $this->db->where('ca.ativo = true');

//        if ($_POST['tipo'] != '') {
//            $this->db->where('ca.tipo', $_POST['tipo']);
//        }

        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00';

        $this->db->where("ca.data_realizacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ca.data_realizacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        if ($_POST['convenio'] != '') {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('c.convenio_id', null);
            } else {
                $this->db->where('c.convenio_id', $_POST['convenio']);
            }
        }
        $this->db->orderby("ca.tipo, ca.data_realizacao");
        $return = $this->db->get();
        return $return->result();
    }

    function impressaoasoparticular($cadastro_aso_id) {
        $this->db->select('ca.*, p.nome as paciente,
                            p.nascimento,
                            p.rg,
                            o.nome as medico,
                            o.conselho,
                            o.telefone,
                            o.celular,
                             ');
        $this->db->from('tb_cadastro_aso ca');
        $this->db->join('tb_paciente p', 'p.paciente_id = ca.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ca.coordenador_id', 'left');
        $this->db->where('cadastro_aso_id', $cadastro_aso_id);
//        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function impressaoaso($cadastro_aso_id) {
        $this->db->select('ca.*, p.nome as paciente,
                            p.nascimento,
                            p.rg,
                            o.nome as medico,
                            o.conselho,
                            o.telefone,
                            o.celular,
                             ');
        $this->db->from('tb_cadastro_aso ca');
        $this->db->join('tb_paciente p', 'p.paciente_id = ca.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ca.medico_responsavel', 'left');
        $this->db->where('cadastro_aso_id', $cadastro_aso_id);
//        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function impressaoaso2($cadastro_aso_id) {
        $this->db->select('ca.*, p.nome as paciente,
                            p.nascimento,
                            p.rg,
                            o.nome as medico,
                            o.conselho,
                            o.telefone,
                            o.celular                            
                                     ');
        $this->db->from('tb_cadastro_aso ca');
        $this->db->join('tb_paciente p', 'p.paciente_id = ca.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ca.medico_responsavel', 'left');
        $this->db->where('cadastro_aso_id', $cadastro_aso_id);
//        $this->db->orderby("nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarriscos() {
        $this->db->select('r.aso_risco_id,
                           r.descricao_risco
                                     ');
        $this->db->from('tb_aso_risco r');

        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentoparticular($aso_id) {
//        var_dump($aso_id);die;
        $this->db->select('ca.impressao_aso');

        $this->db->from('tb_cadastro_aso ca');
        $this->db->where('ca.cadastro_aso_id', $aso_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listarriscosparticular($aso_id) {
//        var_dump($aso_id);die;
        $this->db->select('ca.impressao_aso');

        $this->db->from('tb_cadastro_aso ca');
        $this->db->where('ca.cadastro_aso_id', $aso_id);

        $return = $this->db->get();
        return $return->result();
    }
    
    function listartipoasovalidade($tipo, $convenio_id) {

        $this->db->select('pc.validade');

        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('pt.tipo_aso', $tipo);
        $this->db->where('pc.convenio_id', $convenio_id);

        $return = $this->db->get();
        return $return->result();
    }

    function gravarcadastroaso($gravarempresa, $paciente_id, $ambulatorio_guia) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $valores = json_encode($_POST);

        $this->db->select('pc.valortotal, pc.procedimento_convenio_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->where('pc.ativo', 't');
        if ($_POST['consulta'] == "particular") {
            $this->db->where('pc.convenio_id', $gravarempresa);
        } else {
            $this->db->where('pc.convenio_id', $_POST['convenio1']);
        }
        $this->db->where('pt.grupo', 'ASO');
        $this->db->where('pt.tipo_aso', $_POST['tipo']);
        $result = $this->db->get()->result();

//            echo'<pre>';var_dump($_POST['tipo']);die;

        if (count($result) > 0) {


            if ($_POST['cadastro_aso_id'] > 0) {
                $aso_id = $_POST['cadastro_aso_id'];
                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('impressao_aso', $valores);
                $this->db->set('tipo', $_POST['tipo']);
                $this->db->set('medico_responsavel', $_POST['medico']);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('data_aso', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_realizacao']))));
                $this->db->set('data_realizacao', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_realizacao']))));
                $this->db->set('data_validade', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['validade_exame']))));
                $this->db->set('consulta', $_POST['consulta']);
                if ($_POST['coordenador'] != "") {
                    $this->db->set('coordenador_id', $_POST['coordenador']);
                }
                $this->db->set('guia_id', $ambulatorio_guia);
                if ($_POST['consulta'] == "particular") {
                    $this->db->set('convenio2', $_POST['convenio2']);
                } else {
                    $this->db->set('convenio_id', $_POST['convenio1']);
                }
                $this->db->where('cadastro_aso_id', $aso_id);
                $this->db->update('tb_cadastro_aso');
            } else {
                // var_dump($_POST['consulta']);die;
                $this->db->set('paciente_id', $paciente_id);
                $this->db->set('impressao_aso', $valores);
                $this->db->set('tipo', $_POST['tipo']);
                $this->db->set('medico_responsavel', $_POST['medico']);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('data_aso', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_realizacao']))));
                $this->db->set('data_realizacao', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_realizacao']))));
                $this->db->set('data_validade', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['validade_exame']))));
                $this->db->set('consulta', $_POST['consulta']);
                if ($_POST['coordenador'] != "") {
                    $this->db->set('coordenador_id', $_POST['coordenador']);
                }
                $this->db->set('guia_id', $ambulatorio_guia);
                if ($_POST['consulta'] == "particular") {
                    $this->db->set('convenio2', $_POST['convenio2']);
                } else {
                    $this->db->set('convenio_id', $_POST['convenio1']);
                }
                $this->db->insert('tb_cadastro_aso');
                $aso_id = $this->db->insert_id();
            }

            return $aso_id;
        } else {
            return -1;
        }
    }

    function gravardetalhamentoaso($paciente_id, $cadastro_aso_id) {
        try {

            /* inicia o mapeamento no banco */
            $situacao = $_POST['situacao'];
            $procedimento_id = $_POST['procedimento_id'];
            $count = count($procedimento_id);
//            echo'<pre>'; var_dump($procedimento_id);die;
            for ($i = 0; $i < $count; $i++) {
                
                if ($situacao[$i] != '') {
                    $this->db->set('situacao_aso', $situacao[$i]);
                } else {
                    $this->db->set('situacao_aso', 0);
                }
                $this->db->where('paciente_id', $paciente_id);
                $this->db->where('procedimento_tuss_id', $procedimento_id[$i]);
                $this->db->where('cadastro_aso_id', $cadastro_aso_id);
                $this->db->update('tb_agenda_exames');
            }
            
            return $cadastro_aso_id;
        } catch (Exception $exc) {
            return -1;
        }
    }
    
    function gravardetalhamentonr($cadastro_aso_id, $paciente_id) {
        try { 
            
            $detalhamentonr = array(
                "diagnostico1" => (isset($_POST["diagnostico1"])) ? $_POST["diagnostico1"] : '',
                "diagnostico2" => (isset($_POST["diagnostico2"])) ? $_POST["diagnostico2"] : '',
                "diagnostico3" => (isset($_POST["diagnostico3"])) ? $_POST["diagnostico3"] : '',
                "diagnostico4" => (isset($_POST["diagnostico4"])) ? $_POST["diagnostico4"] : '',
                "diagnostico5" => (isset($_POST["diagnostico5"])) ? $_POST["diagnostico5"] : '',
                "diagnostico6" => (isset($_POST["diagnostico6"])) ? $_POST["diagnostico6"] : '',
                "diagnostico7" => (isset($_POST["diagnostico7"])) ? $_POST["diagnostico7"] : '',
                "diagnostico8" => (isset($_POST["diagnostico8"])) ? $_POST["diagnostico8"] : '',
                "diagnostico9" => (isset($_POST["diagnostico9"])) ? $_POST["diagnostico9"] : '',
                "diagnostico10" => (isset($_POST["diagnostico10"])) ? $_POST["diagnostico10"] : '',
                "diagnostico11" => (isset($_POST["diagnostico11"])) ? $_POST["diagnostico11"] : '',
                "diagnostico12" => (isset($_POST["diagnostico12"])) ? $_POST["diagnostico12"] : ''
            );

                if (count($detalhamentonr) > 0) {
                    $this->db->set('detalhamento_nr', json_encode($detalhamentonr));
                } else {
                    $this->db->set('detalhamento_nr', '');
                }
                
                $this->db->where('cadastro_aso_id', $cadastro_aso_id);
                $this->db->where('paciente_id', $paciente_id);
                
                $this->db->update('tb_cadastro_aso');
            
            
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    
    }

    function excluircadastroaso($cadastro_aso_id) {
//        var_dump($_POST['valor']); die;
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');


        $this->db->set('ativo', 'f');
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('data_atualizacao', $horario);
        $this->db->where('cadastro_aso_id', $cadastro_aso_id);
        $this->db->update('tb_cadastro_aso');

        return true;
    }

    function listarempresasaladepermissao($empresa_id = null) {
        if ($empresa_id == null) {
            $empresa_id = $this->session->userdata('empresa_id');
        }

        $this->db->select('e.empresa_id,
                            ep.campos_atendimentomed,
                            ep.dados_atendimentomed,
                            ordem_chegada,
                            oftamologia,
                            horario_sab,
                            horario_seg_sex,
                            senha_finalizar_laudo,
                            profissional_externo,
                            profissional_agendar,
                            desativar_personalizacao_impressao,
                            desativar_taxa_administracao,
                            retirar_flag_solicitante');
        $this->db->from('tb_empresa e');
        $this->db->where('e.empresa_id', $empresa_id);
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
        $this->db->orderby('e.empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresapermissoes($empresa_id = null) {
        if ($empresa_id == null) {
            $empresa_id = $this->session->userdata('empresa_id');
        }

        $this->db->select('e.empresa_id,
                            ordem_chegada,
                            promotor_medico,
                            excluir_transferencia,
                            orcamento_config,
                            rodape_config,
                            cabecalho_config,
                            valor_recibo_guia,
                            valor_autorizar,
                            gerente_contasapagar,
                            cpf_obrigatorio,
                            orcamento_recepcao,
                            relatorio_ordem,
                            relatorio_producao,
                            relatorios_recepcao,
                            encaminhamento_email,
                            financeiro_cadastro,
                            odontologia_valor_alterar,
                            selecionar_retorno,
                            oftamologia,
                            carregar_modelo_receituario,
                            retirar_botao_ficha,
                            endereco_integracao_lab,
                            identificador_lis,
                            laboratorio,
                            ep.laboratorio_sc,
                            ep.desabilitar_trava_retorno,
                            ep.conjuge,
                            ep.associa_credito_procedimento,
                            ep.valor_laboratorio,
                            ep.desativar_personalizacao_impressao,
                            ep.campos_obrigatorios_pac_cpf,
                            ep.profissional_completo,
                            ep.tecnica_promotor,
                            ep.tecnica_enviar,
                            recibo_config,
                            ep.campos_obrigatorios_pac_sexo,
                            ep.campos_cadastro,
                            ep.campos_atendimentomed,
                            ep.dados_atendimentomed,
                            ep.campos_obrigatorios_pac_nascimento,
                            ep.campos_obrigatorios_pac_telefone,
                            ep.campos_obrigatorios_pac_municipio,
                            ep.reservar_escolher_proc,
                            ep.orcamento_cadastro,
                            ep.repetir_horarios_agenda,
                            ep.senha_finalizar_laudo,
                            ep.gerente_cancelar,
                            ep.valor_convenio_nao,
                            ep.producao_alternativo,
                            ep.apenas_procedimentos_multiplos,
                            ep.percentual_multiplo,
                            ep.ajuste_pagamento_procedimento,
                            ep.valor_autorizar,
                            ep.botao_ficha_convenio,
                            ep.orcamento_multiplo,
                            ep.ocupacao_mae,
                            ep.ocupacao_pai,
                            ep.faturamento_novo,
                            ep.filtrar_agenda,
                            ep.impressao_cimetra,
                            ep.faturamento_novo
                            
                            ');
        $this->db->from('tb_empresa e');
        $this->db->where('e.empresa_id', $empresa_id);
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
        $this->db->orderby('e.empresa_id');
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

    function listarpacientesinternacao($parametro = null) {

        $this->db->select('p.telefone, p.nascimento');
        $this->db->from('tb_paciente p');
        $this->db->where('p.ativo', 't');
        if ($parametro != null) {
            $this->db->where('paciente_id', $parametro);
        }
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarguias($args = array()) {

        $this->db->select('ag.ambulatorio_guia_id,
                            ag.paciente_id,
                            ag.convenio_id,
                            ag.tipo,
                            c.nome as convenio,
                            ag.equipe,
                            ag.equipe_id,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_convenio c', 'c.convenio_id = ag.convenio_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        if (count($args) == 0) {
            $data = date('Y-m-d');
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->where('data_criacao', $data);
            $this->db->where('empresa_id', $empresa_id);
        }

        if (isset($args['guia']) && strlen($args['guia']) > 0) {
            $this->db->where('ag.ambulatorio_guia_id', $args['guia']);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['tipo']) && strlen($args['tipo']) > 0) {
            $this->db->where('ag.tipo', $args['tipo']);
        }
        return $this->db;
    }

    function listar($paciente_id) {

        $this->db->select('ag.ambulatorio_guia_id,
                            ag.paciente_id,
                            ag.empresa_id,
                            ag.valor_guia,
                            ag.data_cadastro,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->where("ag.paciente_id", $paciente_id);
        $this->db->orderby('ag.ambulatorio_guia_id', 'desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaosadtcadastrar($solicitacao_id) {

        $this->db->select('ss.solicitacao_sadt_id,
                            ss.paciente_id,
                            ss.empresa_id,
                            c.nome as convenio,
                            c.convenio_id,
                            o.nome as solicitante,
                            ss.data_cadastro,
                            p.nome as paciente');
        $this->db->from('tb_solicitacao_sadt ss');
        $this->db->join('tb_paciente p', 'p.paciente_id = ss.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = ss.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ss.medico_solicitante', 'left');
        $this->db->where("ss.solicitacao_sadt_id", $solicitacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacaosadt($paciente_id) {

        $this->db->select('ss.solicitacao_sadt_id,
                            ss.paciente_id,
                            ss.empresa_id,
                            c.nome as convenio,
                            o.nome as solicitante,
                            ss.data_cadastro,
                            p.nome as paciente');
        $this->db->from('tb_solicitacao_sadt ss');
        $this->db->join('tb_paciente p', 'p.paciente_id = ss.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = ss.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ss.medico_solicitante', 'left');
        $this->db->where("ss.paciente_id", $paciente_id);
        $this->db->orderby('ss.solicitacao_sadt_id', 'desc');
        $return = $this->db->get();
        return $return->result();
    }

    function impressaoguiasolicitacaopsadt($solicitacao_id) {

        $this->db->select('ss.solicitacao_sadt_id,
                            ss.paciente_id,
                            ss.empresa_id,
                            ssp.solicitacao_sadt_procedimento_id,
                            ssp.quantidade,
                            ssp.valor,
                            o.nome as solicitante,
                            c.nome as convenio,
                            c.codigoidentificador,
                            c.registroans,
                            c.caminho_logo,
                            o.cbo_ocupacao_id as cbo,
                            ms.codigo_ibge,
                            o.conselho,
                            p.convenionumero,
                            p.vencimento_carteira,
                            pt.nome as procedimento,
                            pt.codigo as codigo_procedimento,
                            ss.data_cadastro,
                            p.nome as paciente');
        $this->db->from('tb_solicitacao_sadt_procedimento ssp');
        $this->db->join('tb_solicitacao_sadt ss', 'ssp.solicitacao_sadt_id = ss.solicitacao_sadt_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ssp.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = ss.convenio_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ss.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ss.medico_solicitante', 'left');
        $this->db->join('tb_municipio ms', 'ms.municipio_id = o.municipio_id', 'left');
        $this->db->where("ss.solicitacao_sadt_id", $solicitacao_id);
        $this->db->where("ssp.ativo", 't');
        $this->db->orderby('ssp.solicitacao_sadt_procedimento_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioguiasadt() {

        $this->db->select('ss.solicitacao_sadt_id,
                            ss.paciente_id,
                            ss.empresa_id,
                            ss.data_cadastro,
                            ssp.solicitacao_sadt_procedimento_id,
                            ssp.quantidade,
                            ssp.valor,
                            o.nome as solicitante,
                            c.nome as convenio,
                            c.codigoidentificador,
                            c.registroans,
                            c.caminho_logo,
                            o.cbo_ocupacao_id as cbo,
                            ms.codigo_ibge,
                            o.conselho,
                            p.convenionumero,
                            p.vencimento_carteira,
                            pt.nome as procedimento,
                            pt.codigo as codigo_procedimento,
                            ss.data_cadastro,
                            p.nome as paciente');
        $this->db->from('tb_solicitacao_sadt_procedimento ssp');
        $this->db->join('tb_solicitacao_sadt ss', 'ssp.solicitacao_sadt_id = ss.solicitacao_sadt_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ssp.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = ss.convenio_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ss.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ss.medico_solicitante', 'left');
        $this->db->join('tb_municipio ms', 'ms.municipio_id = o.municipio_id', 'left');
        $this->db->where("ss.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where("ss.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        $this->db->where("ssp.ativo", 't');
        if ($_POST['medico'] > 0) {
            $this->db->where("ss.medico_solicitante", $_POST['medico']);
        }
        if ($_POST['convenio'] > 0) {
            $this->db->where("c.convenio_id", $_POST['convenio']);
        }
        $this->db->orderby('ssp.solicitacao_sadt_id, data_cadastro desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentosguiasadt($solicitacao_id) {

        $this->db->select('ss.solicitacao_sadt_id,
                            ss.paciente_id,
                            ss.empresa_id,
                            ssp.solicitacao_sadt_procedimento_id,
                            ssp.quantidade,
                            o.nome as solicitante,
                            c.nome as convenio,
                            pt.nome as procedimento,
                            ss.data_cadastro,
                            p.nome as paciente');
        $this->db->from('tb_solicitacao_sadt_procedimento ssp');
        $this->db->join('tb_solicitacao_sadt ss', 'ssp.solicitacao_sadt_id = ss.solicitacao_sadt_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ssp.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = ss.convenio_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ss.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ss.medico_solicitante', 'left');
        $this->db->where("ss.solicitacao_sadt_id", $solicitacao_id);
        $this->db->where("ssp.ativo", 't');
        $this->db->orderby('ssp.solicitacao_sadt_procedimento_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarfiladeimpressao() {

        $this->db->select('afi.ambulatorio_fila_impressao_id');
        $this->db->from('tb_ambulatorio_fila_impressao afi');
        $this->db->join('tb_operador o', 'o.operador_id = afi.operador_solicitante', 'left');
        $this->db->where('afi.ativo', 't');

//        $this->db->orderby('afi.data_cadastro', 'desc');
        return $this->db;
    }

    function listarfiladeimpressao2() {

        $this->db->select('fi.*, op.nome as solicitante, p.nome as paciente');
        $this->db->from('tb_ambulatorio_fila_impressao fi');
        $this->db->join('tb_operador op', 'op.operador_id = fi.operador_solicitante', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = fi.paciente_id', 'left');
        $this->db->where('fi.ativo', 't');
//        $this->db->orderby('fi.data_cadastro', 'desc');
        return $this->db;
    }

    function gerarimpressaofiladeimpressao($impressao_id) {

        $this->db->select('fi.texto');
        $this->db->from('tb_ambulatorio_fila_impressao fi');
        $this->db->where('fi.ambulatorio_fila_impressao_id', $impressao_id);
        $return = $this->db->get();

        $this->db->set('ativo', 'f');
        $this->db->where('ambulatorio_fila_impressao_id', $impressao_id);
        $this->db->update('tb_ambulatorio_fila_impressao');

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
                            emp.email,
                            ae.empresa_id,
                            ae.entregue,
                            ae.data_entregue,
                            ae.procedimento_possui_ajuste_pagamento,
                            al.ambulatorio_laudo_id, 
                            al.exame_id,
                            p.nome as paciente,
                            p.indicacao,
                            p.nascimento,
                            ae.entregue_telefone,
                            o.nome as operadorrecebido,
                            op.nome as operadorentregue,
                            oz.nome as atendente,
                            pi.nome as promotor,
                            om.nome as medicorealizou,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            ag.tipo grupo,
                            ae.data_antiga
                            ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id= pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->join('tb_empresa emp', 'emp.empresa_id = ae.empresa_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_recebido', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_entregue', 'left');
        $this->db->join('tb_operador om', 'om.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_operador oz', 'oz.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'ae.indicacao = pi.paciente_indicacao_id', 'left');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('pt.nome is not null');
        $this->db->where('pt.grupo !=', 'CIRURGICO');
        $this->db->where("ae.paciente_id", $paciente_id);
        $this->db->orderby('ae.guia_id');
        $this->db->orderby('ae.agenda_exames_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexames2($paciente_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.faturado,
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
                            ae.procedimento_possui_ajuste_pagamento,
                            al.ambulatorio_laudo_id, 
                            al.exame_id,
                            p.nome as paciente,
                            p.indicacao,
                            p.nascimento,
                            ae.entregue_telefone,
                            o.nome as operadorrecebido,
                            op.nome as operadorentregue,
                            oz.nome as atendente,
                            pi.nome as promotor,
                            om.nome as medicorealizou,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            ag.tipo grupo,
                            ae.data_antiga
                            ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id= pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->join('tb_empresa emp', 'emp.empresa_id = ae.empresa_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_recebido', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_entregue', 'left');
        $this->db->join('tb_operador om', 'om.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_operador oz', 'oz.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'ae.indicacao = pi.paciente_indicacao_id', 'left');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('pt.nome is not null');
        $this->db->where('pt.grupo !=', 'CIRURGICO');
        $this->db->where("ae.paciente_id", $paciente_id);
        $this->db->orderby('ae.guia_id');
        $this->db->orderby('ae.agenda_exames_id');
        $return = $this->db->get();
        return $return->result();
    }

    function guiaspsadtoutrasdespesas($guia_id) {

        $this->db->select(' ag.guiaconvenio,
                            ag.data_criacao,
                            ag.convenio_id,
                            c.nome as convenio,
                            c.registroans,
                            c.codigoidentificador,
                            ag.ambulatorio_guia_id,
                            c.dinheiro,
                            c.tabela,
                            p.convenionumero,
                            pt.nome as procedimento,
                            pt.codigo as codigo_procedimento,
                            ags.descricao,
                            ags.valor,
                            ags.quantidade,
                            ep.descricao as produto,                            
                            u.descricao as unidade
                            ');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_ambulatorio_gasto_sala ags', 'ags.guia_id = ag.ambulatorio_guia_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = ags.produto_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id = ep.unidade_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = ag.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = ep.procedimento_id', 'left');
//        $this->db->join('tb_procedimento_convenio pc', 'ep.procedimento_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ags.ativo", 't');
//        $this->db->where("(ag.convenio_id = pc.convenio_id)");
//        $this->db->where("(ep.procedimento_id = pc.procedimento_tuss_id)");
        $this->db->where("pt.ativo", 't');
        $this->db->where("ag.ambulatorio_guia_id", $guia_id);

        $return = $this->db->get();
        return $return->result();
    }

    function guiaspsadtoutrasdespesasconvenio($guia_id) {

        $this->db->select(' c.nome as convenio,
                            c.registroans,
                            c.convenio_id,
                            c.caminho_logo,
                            c.codigoidentificador,
                            c.dinheiro,
                            c.tabela');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'ae.procedimento_tuss_id = pc.procedimento_convenio_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ae.guia_id", $guia_id);

        $return = $this->db->get();
        return $return->result();
    }

    function impressaoguiaconsultaspsadt($guia_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.faturado,
                            ae.agenda_exames_nome_id,
                            ae.valor,
                            ae.quantidade,
                            ae.situacao,
                            ae.cancelada,
                            ae.autorizacao,
                            ag.guiaconvenio,
                            e.exames_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            c.registroans,
                            c.codigoidentificador,
                            c.caminho_logo,
                            ae.guia_id,
                            e.situacao as situacaoexame,
                            al.situacao as situacaolaudo,
                            ae.paciente_id,
                            c.dinheiro,
                            c.tabela,
                            ae.recebido,
                            ae.data_recebido,
                            ae.empresa_id,
                            emp.nome as empresa,
                            ae.empresa_id,
                            ms.codigo_ibge,
                            me.codigo_ibge as codigo_ibge_executante,
                            o.cbo_ocupacao_id as cbo,
                            o.municipio_id,
                            o.conselho,
                            o.nome as solicitante,
                            oe.cpf as cpf_executante,
                            oe.cbo_ocupacao_id as cbo_executante,
                            oe.municipio_id as municipio_executante,
                            oe.conselho as conselho_executante,
                            oe.nome as executante,
                            ae.data_autorizacao,
                            ae.entregue,
                            ae.data_entregue,
                            p.nome as paciente,
                            p.indicacao,
                            p.nascimento,
                            p.convenionumero,
                            ae.entregue_telefone,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.codigo as codigo_procedimento,
                            ae.data_antiga
                            ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_guia ag', 'ag.ambulatorio_guia_id = ae.guia_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id= pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_empresa emp', 'emp.empresa_id = ae.empresa_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador oe', 'oe.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_municipio ms', 'ms.municipio_id = o.municipio_id', 'left');
        $this->db->join('tb_municipio me', 'me.municipio_id = oe.municipio_id', 'left');
        $this->db->where('ae.confirmado', 't');
        $this->db->where("ae.guia_id", $guia_id);
        $this->db->orderby('ae.guia_id');
        $this->db->orderby('ae.agenda_exames_id');

        $return = $this->db->get();
        return $return->result();
    }

    function impressaoguiaconsultaspsadtprocedimento($agenda_exames_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.faturado,
                            ae.agenda_exames_nome_id,
                            ae.valor,
                            ae.quantidade,
                            ae.situacao,
                            ae.cancelada,
                            ae.autorizacao,
                            ag.guiaconvenio,
                            e.exames_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            c.registroans,
                            c.codigoidentificador,
                            ae.guia_id,
                            e.situacao as situacaoexame,
                            al.situacao as situacaolaudo,
                            ae.paciente_id,
                            c.dinheiro,
                            c.tabela,
                            ae.recebido,
                            ae.data_recebido,
                            ae.empresa_id,
                            emp.nome as empresa,
                            ae.empresa_id,
                            ms.codigo_ibge,
                            me.codigo_ibge as codigo_ibge_executante,
                            o.cbo_ocupacao_id as cbo,
                            o.municipio_id,
                            o.conselho,
                            o.nome as solicitante,
                            oe.cpf as cpf_executante,
                            oe.cbo_ocupacao_id as cbo_executante,
                            oe.municipio_id as municipio_executante,
                            oe.conselho as conselho_executante,
                            oe.nome as executante,
                            ae.data_autorizacao,
                            ae.entregue,
                            ae.data_entregue,
                            p.nome as paciente,
                            p.indicacao,
                            p.nascimento,
                            p.convenionumero,
                            ae.entregue_telefone,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            pt.codigo as codigo_procedimento,
                            ae.data_antiga
                            ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_guia ag', 'ag.ambulatorio_guia_id = ae.guia_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id= pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_empresa emp', 'emp.empresa_id = ae.empresa_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador oe', 'oe.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_municipio ms', 'ms.municipio_id = o.municipio_id', 'left');
        $this->db->join('tb_municipio me', 'me.municipio_id = oe.municipio_id', 'left');
        $this->db->where('ae.confirmado', 't');
        $this->db->where("ae.agenda_exames_id", $agenda_exames_id);
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

    function listarconvenios() {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select(' c.convenio_id,
                            c.nome');
        $this->db->from('tb_convenio c');
        $this->db->join('tb_convenio_empresa ce', 'ce.convenio_id = c.convenio_id', 'left');
        $this->db->where("c.ativo", 'true');
        $this->db->where("ce.empresa_id", $empresa_id);
        $this->db->where("ce.ativo", 'true');
        $this->db->orderby("c.nome");
        $query = $this->db->get();
        $return = $query->result();

        return $return;
    }

    function listaragendaexames($aso_id) {

        $this->db->select('ae.agenda_exames_id');

        $this->db->from('tb_agenda_exames ae');
        $this->db->where("ae.aso_id", $aso_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listarcadastroaso($paciente_id) {
        $empresa_id = $this->session->userdata('empresa_id');
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('ca.cadastro_aso_id,
                            ca.tipo,
                            ca.guia_id,
                            ca.consulta,
                            p.paciente_id,
                            p.nome as paciente,
                            ca.data_cadastro,
                            ca.data_realizacao,
                            ca.data_aso,
                            c.dinheiro,
                            ca.consulta');

        $this->db->from('tb_cadastro_aso ca');
        $this->db->join('tb_paciente p', 'p.paciente_id = ca.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = ca.convenio_id', 'left');
        $this->db->where("ca.ativo", 'true');
        $this->db->where("p.paciente_id", $paciente_id);
//        $this->db->where("ca.medico_responsavel", $operador_id);

        return $this->db;
    }

    function listarprocedimentoscadastroaso($cadastro_aso_id) {

        $this->db->select('pc.procedimento_convenio_id,
                            pt.nome,
                            ae.aso_id,
                            ca.consulta,
                            ae.situacao_aso,
                            ae.guia_id,
                            ae.agenda_exames_id,
                            ae.cadastro_aso_id,
                            pt.codigo,
                            pt.descricao,
                            pt.grupo,
                            pt.tipo_aso');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.procedimento_tuss_id = pc.procedimento_convenio_id', 'left');
        $this->db->join('tb_cadastro_aso ca', 'ca.cadastro_aso_id = ae.cadastro_aso_id', 'left');
        $this->db->where("ae.cadastro_aso_id", $cadastro_aso_id);
        $this->db->where("pc.ativo", 't');

        return $this->db;
    }

    function carregarcadastroaso($cadastro_aso_id) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('ca.cadastro_aso_id,
                            ca.tipo,
                            ca.impressao_aso,
                            ca.medico_responsavel,
                            ca.data_cadastro,
                            p.nome as paciente
                            ');
        $this->db->from('tb_cadastro_aso ca');
        $this->db->join('tb_paciente p', 'p.paciente_id = ca.paciente_id', 'left');
        $this->db->where("ca.cadastro_aso_id", $cadastro_aso_id);

        $this->db->orderby("ca.cadastro_aso_id");
        $query = $this->db->get();
        $return = $query->result();

        return $return;
    }

    function carregarcadastroaso2($paciente_id) {

        $this->db->select(' ca.ativo,
                            ca.tipo,
                            ca.impressao_aso,
                            ca.medico_responsavel,
                            ca.data_cadastro,
                            p.nome as paciente,
                            p.paciente_id
                            ');
        $this->db->from('tb_cadastro_aso ca');
        $this->db->join('tb_paciente p', 'p.paciente_id = ca.paciente_id', 'left');
        $this->db->where("p.paciente_id", $paciente_id);
        $this->db->where("ca.ativo", 'TRUE');

        $this->db->orderby("ca.data_cadastro");
        $return = $this->db->get();
        return $return->result();
    }

    function instanciarguia($guia_id = null) {

        $this->db->select(' ag.ambulatorio_guia_id,
                            ag.tipo,
                            ag.observacoes,
                            ag.via,
                            ag.leito,
                            ag.equipe,
                            ag.equipe_id,
                            c.convenio_id,
                            c.nome as convenio,
                            p.paciente_id,
                            p.telefone,
                            p.sexo,
                            p.nascimento,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = ag.convenio_id', 'left');
        $this->db->where("ag.ambulatorio_guia_id", $guia_id);
        $query = $this->db->get();
        $return = $query->result();

        return $return;
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
                            ae.data_antiga,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            emp.nome as empresa,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor,
                            ae.valor1,
                            ae.ajuste_cbhpm,
                            ae.valor_total,
                            ae.autorizacao,
                            pc.qtdech,
                            pc.valorch,
                            ae.paciente_id,
                            ae.faturado,
                            o.nome as medico,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            ag.tipo,
                            pt.grupo,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        if (@$_POST['grupotipo'] != '') {
            $this->db->join('tb_classificacao_grupo_associar ogm', 'tu.classificacao = ogm.operador_id', 'left');
        }

        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_empresa emp', 'emp.empresa_id = ae.empresa_id', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');
        if (isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $_POST['nome'] . "%");
        }
        if ($_POST['data_atendimento'] != "0") {
            $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        } else {
            $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        }

        if (isset($_POST['filtro_hora'])) {
            $_POST['horario_inicio'] = ($_POST['horario_inicio'] == '') ? '00:00' : $_POST['horario_inicio'];
            $_POST['horario_fim'] = ($_POST['horario_fim'] == '') ? '00:00' : $_POST['horario_fim'];

            $this->db->where("ae.inicio >=", $_POST['horario_inicio']);
            $this->db->where("ae.inicio <=", $_POST['horario_fim']);
        }
        if (@$_POST['grupotipo'] != '') {
            $this->db->where('ogm.classificacao_grupo_id', $_POST['grupotipo']);
            $this->db->where('ogm.ativo', 't');
        }

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
        if (@$_POST['situacao_faturamento'] != "") {
            $this->db->where("ae.situacao_faturamento", $_POST['situacao_faturamento']);
        }
        if (@$_POST['subgrupo_id'] != "" && $this->session->userdata('subgrupo_procedimento') == 't') {
            $this->db->where("pt.subgrupo_id", $_POST['subgrupo_id']);
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
        if (isset($_POST['medico'])) {
            if (in_array("0", $_POST['medico'])) {
                $todos = true;
            } else {
                $todos = false;
            }
        } else {
            $todos = false;
        }
        @$medicos = array_unique($_POST['medico']);
        @$medicos = implode(', ', $medicos);
//        var_dump($medicos);
//        die;

        if (count(@$_POST['medico']) != 0 && !$todos) {
            $this->db->where("al.medico_parecer1 IN ($medicos)");
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

    function relatoriocomparativomensal($data1, $data2) {

        $this->db->select('c.nome as convenio,
                            sum(ae.valor_total) as valor_total
                            ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_empresa emp', 'emp.empresa_id = ae.empresa_id', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');

        if ($_POST['data_atendimento'] != "0") {
            $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $data1))));
            $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $data2))));
        } else {
            $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $data1))));
            $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $data2))));
        }

        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "" && $_POST['convenio'] != "-1") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if (@$_POST['situacao_faturamento'] != "") {
            $this->db->where("ae.situacao_faturamento", $_POST['situacao_faturamento']);
        }
        if ($_POST['faturamento'] != "0") {
            $this->db->where("ae.faturado", $_POST['faturamento']);
        }

        if (isset($_POST['medico'])) {
            if (in_array("0", $_POST['medico'])) {
                $todos = true;
            } else {
                $todos = false;
            }
        } else {
            $todos = false;
        }
        @$medicos = array_unique($_POST['medico']);
        @$medicos = implode(', ', $medicos);
//        var_dump($medicos);
//        die;

        if (count(@$_POST['medico']) != 0 && !$todos) {
            $this->db->where("al.medico_parecer1 IN ($medicos)");
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
        $this->db->groupby('c.nome, c.convenio_id');
        $this->db->orderby('c.nome');

        $return = $this->db->get();
        return $return->result();
    }

    function relatorioexamesrecolhimento() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.data_antiga,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            emp.nome as empresa,
                            al.ambulatorio_laudo_id as laudo,
                            ae.situacao,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor,
                            ae.valor1,
                            ae.ajuste_cbhpm,
                            ae.valor_total,
                            ae.autorizacao,
                            pc.qtdech,
                            pc.valorch,
                            ae.paciente_id,
                            ae.faturado,
                            o.nome as medico,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as exame,
                            ag.tipo,
                            pt.grupo,
                            pt.descricao as procedimento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');


        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_empresa emp', 'emp.empresa_id = ae.empresa_id', 'left');
        $this->db->where('ae.realizada', 'true');
        $this->db->where('ae.cancelada', 'false');

        if ($_POST['data_atendimento'] != "0") {
            $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        } else {
            $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        }

        if (isset($_POST['filtro_hora'])) {
            $_POST['horario_inicio'] = ($_POST['horario_inicio'] == '') ? '00:00' : $_POST['horario_inicio'];
            $_POST['horario_fim'] = ($_POST['horario_fim'] == '') ? '00:00' : $_POST['horario_fim'];

            $this->db->where("ae.inicio >=", $_POST['horario_inicio']);
            $this->db->where("ae.inicio <=", $_POST['horario_fim']);
        }


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
        if (@$_POST['situacao_faturamento'] != "") {
            $this->db->where("ae.situacao_faturamento", $_POST['situacao_faturamento']);
        }
        if (@$_POST['subgrupo_id'] != "") {
            $this->db->where("pt.subgrupo_id", $_POST['subgrupo_id']);
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

//        @$medicos = array_unique($_POST['medico']);
//        @$medicos = implode(', ', $medicos);
//        var_dump($medicos);
//        die;

        if (@$_POST['medico'] != 0) {
            $this->db->where("al.medico_parecer1", $_POST['medico']);
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

    function exportaremails() {

        $this->db->select('p.paciente_id,
                           p.nome as paciente,
                           p.cns 
                            ');
        $this->db->from('tb_paciente p');
        $this->db->where("p.cns != ''");
        $this->db->where('p.ativo', 't');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
//        var_dump($return->result()); die;
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
        if ($_POST['data_atendimento'] != "0") {
            $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        } else {
            $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        }
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

    function relatorioexamesch() {

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
                            oe.nome as operador_aut,
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
        $this->db->join('tb_operador oe', 'oe.operador_id = ae.operador_autorizacao', 'left');
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

    function gerarelatoriotempoatendimento() {

        $this->db->select('ae.agenda_exames_id,
                            p.paciente_id,
                           p.nome as paciente,
                           p.sexo,
                           p.nascimento,
                           p.estado_civil_id,
                           p.data_cadastro,
                           p.escolaridade_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.chegada,
                            ae.atendimento,
                            ae.data_atendimento,
                            ae.data_realizacao,
                            ae.data_autorizacao,
                            al.situacao,
                            al.data_finalizado,
                            al.data_atualizacao,
                            ae.data_chegada,
                            e.data_cadastro,
                            ae.guia_id,
                            ae.realizada,
                            ae.confirmado
                                        ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');

//        $this->db->where("ae.atendimento", 't');
        $this->db->where("al.situacao", 'FINALIZADO');

        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));

        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        if ($_POST['medico'] > 0) {
            $this->db->where("al.medico_parecer1", $_POST['medico']);
        }

        if ($_POST['procedimentos']) {
            $this->db->where("pc.procedimento_tuss_id", $_POST['procedimentos']);
        }


        $return = $this->db->get();
        return $return->result();
    }

    function gerarelatoriosituacaoatendimento() {
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
                            ae.medico_consulta_id,
                            al.medico_parecer1,
                            al.ambulatorio_laudo_id,
                            al.exame_id,
                            al.data as data_atendimento,
                            pt.entrega,
                            e.situacao as situacaoexame,
                            al.procedimento_tuss_id,
                            p.paciente_id,
                            o.nome as medicoconsulta,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            ae.confirmado,
                            e.exames_id,
                            ae.agenda_exames_nome_id as sala_id,
                            ag.tipo,
                            pt.grupo,
                            c.nome as convenio,
                            pt.nome as procedimento,
                            al.situacao as situacaolaudo,
                            al.observacao_laudo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.tipo !=', 'CIRURGICO');
        $this->db->where('ae.paciente_id IS NOT NULL');
        $this->db->where('ae.cancelada', 'false');
        if ($_POST['situacao'] != '') {
            $this->db->where('al.situacao', $_POST['situacao']);
        }
        if ($_POST['grupo'] != '') {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['empresa'] != '') {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('ae.data >=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where('ae.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->get();
        return $return->result();
    }

    function gerarelatorioexamefaltou() {

        $_POST['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $_POST['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ae.agenda_exames_id,
                            p.celular,
                            p.telefone,
                            p.nome as paciente,
                            p.cns,
                            pt.nome as procedimento,
                            pt.grupo,
                            p.sexo,
                            p.nascimento,
                            p.estado_civil_id,
                            p.raca_cor,
                            m.nome as cidade,
                            ae.tipo,
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
        if ($_POST['situacao'] == 'FALTOU') {
            if ($data_atual > $_POST['txtdata_fim']) {
                $this->db->where('ae.data <=', $_POST['txtdata_fim']);
            } else {
                $this->db->where('ae.data <', $data_atual);
            }

            $this->db->where('ae.situacao', 'OK');
            $this->db->where('ae.realizada', 'f');
            $this->db->where('ae.bloqueado', 'f');
            $this->db->where('ae.operador_atualizacao is not null');
        } elseif ($_POST['situacao'] == 'COMPARECEU') {
            $this->db->where('ae.data <=', $_POST['txtdata_fim']);
            $this->db->where('ae.realizada', 't');
            $this->db->where('ae.operador_atualizacao is not null');
        } else {
            $this->db->where('ae.data <=', $_POST['txtdata_fim']);
        }

        if ($_POST['grupo'] != '') {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['raca_cor'] != '') {
            $this->db->where('p.raca_cor', $_POST['raca_cor']);
        }
        if ($_POST['estado_civil_id'] != '') {
            $this->db->where('p.estado_civil_id', $_POST['estado_civil_id']);
        }

        if ($_POST['sexo'] != '') {
            $this->db->where('p.sexo', $_POST['sexo']);
        }
        if ($_POST['idade_maior'] > 0) {
            $idade_maior = $_POST['idade_maior'];
            $this->db->where("substring(NOW()::text from 1 for 4)::integer - substring(p.nascimento::text from 1 for 4)::integer  > $idade_maior");
        }
        if ($_POST['idade_menor'] > 0) {
            $idade_menor = $_POST['idade_menor'];
            $this->db->where("substring(NOW()::text from 1 for 4)::integer - substring(p.nascimento::text from 1 for 4)::integer  < $idade_menor");
        }

        if ($_POST['empresa'] != '') {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }

        $this->db->where('ae.paciente_id is not null');
        $this->db->orderby('ae.agenda_exames_id');
        $this->db->orderby('p.nome');


        $return = $this->db->get();
        return $return->result();
    }

    function gerarelatorioexamefaltouemail() {

        $_POST['txtdata_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $_POST['txtdata_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('
                            p.cns
                            
                            ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_municipio m', 'p.municipio_id = m.municipio_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        date_default_timezone_set('America/Fortaleza');
        $data_atual = date('Y-m-d');
        $this->db->where('ae.data >=', $_POST['txtdata_inicio']);
        if ($_POST['situacao'] == 'FALTOU') {
            if ($data_atual > $_POST['txtdata_fim']) {
                $this->db->where('ae.data <=', $_POST['txtdata_fim']);
            } else {
                $this->db->where('ae.data <', $data_atual);
            }

            $this->db->where('ae.situacao', 'OK');
            $this->db->where('ae.realizada', 'f');
            $this->db->where('ae.bloqueado', 'f');
            $this->db->where('ae.operador_atualizacao is not null');
        } elseif ($_POST['situacao'] == 'COMPARECEU') {
            $this->db->where('ae.data <=', $_POST['txtdata_fim']);
            $this->db->where('ae.realizada', 't');
            $this->db->where('ae.operador_atualizacao is not null');
        } else {
            $this->db->where('ae.data <=', $_POST['txtdata_fim']);
        }

        $this->db->where('ae.paciente_id is not null');
        $this->db->orderby('ae.agenda_exames_id');
        $this->db->orderby('p.nome');
        if ($_POST['empresa'] != '') {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }


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
                            ae.valor_total,
                            ae.situacao,
                            c.nome as convenio,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
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
        $this->db->where('ae.realizada', 't');
        $this->db->where("ae.procedimento_tuss_id", $_POST['procedimento1']);
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarajustarvalorprocedimentocbhpm() {
//        echo 'aqui';
//        die;
        $this->db->select('distinct(ae.guia_id)
                            ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.empresa_id', $_POST['empresa']);
//        $this->db->where('ae.faturado', 't');
        $this->db->where("pt.grupo", $_POST['grupo']);
        $this->db->where("ae.realizada", 't');
        $this->db->where("pc.convenio_id", $_POST['convenio1']);
        $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $return = $this->db->get()->result();
//        echo '<pre>';
//        var_dump($return);
//        die;

        $this->db->select('procedimento1,
                                procedimento2,
                                nome,
                                tabela
                            ');
        $this->db->from('tb_convenio c');
        $this->db->where('c.convenio_id', $_POST['convenio1']);
        $return_convenio = $this->db->get()->result();
//        var_dump($return_convenio); die;
        $tipo = $return_convenio[0]->tabela;
        if ($return_convenio[0]->procedimento1 != '') {
            $procedimento1 = $return_convenio[0]->procedimento1;
        }

        if ($return_convenio[0]->procedimento2 != '') {
            $procedimento2 = $return_convenio[0]->procedimento2;
        }

        foreach ($return as $value) {

            $this->db->select('ae.agenda_exames_id,
                               ae.valor_total,
                               pc.*
                            ');
            $this->db->from('tb_agenda_exames ae');
            $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
            $this->db->where("pt.grupo", $_POST['grupo']);
            $this->db->where("pc.convenio_id", $_POST['convenio1']);
            $this->db->where('ae.ajuste_cbhpm', 'f');
            $this->db->where('ae.guia_id', $value->guia_id);
//            $this->db->groupby('ae.guia_id');
//            $this->db->groupby('ae.agenda_exames_id');
            $this->db->orderby('ae.valor_total desc');
            $return2 = $this->db->get()->result();

            $b = 0;


            foreach ($return2 as $value2) {
                if ($tipo == 'CBHPM') {
                    if ($b == 0) {
                        $valor_total = ($value2->qtdech * $value2->valorch) + ($value2->qtdefilme * $value2->valorfilme) + ($value2->qtdeporte * $value2->valorporte) + (($value2->qtdeuco * $value2->valoruco) * ($procedimento1 / 100));
                        $b++;
                    } else {
                        $valor_total = ($value2->qtdech * $value2->valorch) + ($value2->qtdefilme * $value2->valorfilme) + ($value2->qtdeporte * $value2->valorporte) + (($value2->qtdeuco * $value2->valoruco) * ($procedimento2 / 100));
                    }
//                    die;
                } else {

                    if ($b == 0) {
                        $valor_total = (float) ($value2->valor_total * ($procedimento1 / 100));
                        $b++;
                    } else {
                        $valor_total = (float) ($value2->valor_total * ($procedimento2 / 100));
                    }
                }
//                echo round($valor_total, 2) . '<br>';

                $this->db->set('ajuste_cbhpm', 't');
                $this->db->set('valor_total', $valor_total);
                $this->db->where('agenda_exames_id', $value2->agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }
        }
//        die;
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
            e.situacao,
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
//        $this->db->where('e.situacao', 'FINALIZADO');
//        var_dump($_POST['situacao']); die;
        if ($_POST['situacao'] == "1") {
            $this->db->where('al.situacao', 'FINALIZADO');
        } elseif ($_POST['situacao'] == "0") {
            $this->db->where('al.situacao !=', 'FINALIZADO');
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
//        $this->db->where("ae.data >=", date("Y-m-d", strtotime($_POST['txtdata_inicio'])));
//        $this->db->where("ae.data <=", date("Y-m-d", strtotime($_POST['txtdata_fim'])));
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
        if ($_POST['data_atendimento'] != "0") {
            $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        } else {
            $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        }
        $this->db->groupby('c.nome');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioresumogeralconveniounico() {

        $this->db->select('c.convenio_id,c.nome as convenio,c.dinheiro,sum(ae.valor_total)as valor_teste,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("(e.cancelada = false OR ae.tipo = 'CIRURGICO')");
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("(ae.valor_medico is not null OR ae.tipo = 'CIRURGICO')");
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('c.convenio_id,c.nome');
        $this->db->groupby('c.dinheiro');
        $this->db->orderby('c.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioresumogeralconvenio() {

        $this->db->select('c.nome as convenio,c.convenio_id,c.dinheiro,ae.forma_pagamento as forma_pagamento1,
                          ae.forma_pagamento2,  
                          ae.forma_pagamento3,  
                          ae.forma_pagamento4,  
                          ae.valor1,  
                          ae.valor2,  
                          ae.valor3,  
                          ae.valor4,  
            ae.valor_total as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("(e.cancelada = false OR ae.tipo = 'CIRURGICO')");
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("(ae.valor_medico is not null OR ae.tipo = 'CIRURGICO')");
//        $this->db->where('e.situacao', 'FINALIZADO');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
//        $this->db->groupby('c.nome');
//        $this->db->groupby('c.dinheiro');
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

        $this->db->select('
            ae.medico_solicitante,
            o.nome as medico,
            sum(ae.quantidade) as quantidade,
            sum(ae.valor_total)as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
//        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id');
//        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->where('ae.confirmado', 't');
        $this->db->where('ae.realizada', 't');
        if ($_POST['medicos'] != "0") {
            $this->db->where('ae.medico_solicitante', $_POST['medicos']);
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
        if ($_POST['data_atendimento'] != "0") {
            $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        } else {
            $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        }
        $this->db->groupby('ae.medico_solicitante, o.nome');
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
        if ($_POST['data_atendimento'] != "0") {
            $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        } else {
            $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        }
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
        if ($_POST['data_atendimento'] != "0") {
            $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        } else {
            $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        }
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
        if ($_POST['data_atendimento'] != "0") {
            $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        } else {
            $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        }
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
        if ($_POST['data_atendimento'] != "0") {
            $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        } else {
            $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        }
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
        if ($_POST['data_atendimento'] != "0") {
            $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        } else {
            $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
            $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        }
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
        $this->db->where("al.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("al.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
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
            ae.valor_medico,
            ae.agenda_exames_id,
            ae.percentual_medico,
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

        $perfil_id = $this->session->userdata('perfil_id');
        if ($perfil_id == 4) { // medico so pode ver o relatorio dele
            $operador_id = $this->session->userdata('operador_id');
            $this->db->where('al.medico_parecer1', $operador_id);
        } else {
            if ($_POST['medicos'] != "0") {
                $this->db->where('al.medico_parecer1', $_POST['medicos']);
            }
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
            ae.valor_promotor,
            ae.valor_total,
            ae.percentual_promotor,
            pi.nome as indicacao');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao');
        $this->db->join('tb_agenda_exames ae', 'ae.paciente_id = p.paciente_id');
        if ($_POST['indicacao'] != "0") {
            $this->db->where("p.indicacao", $_POST['indicacao']);
        } else {
            $this->db->where("p.indicacao is not null");
        }

        if ($_POST['grupo_indicacao'] != "0") {
            $this->db->where('pi.grupo_id', $_POST['grupo_indicacao']);
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

    function relatorioindicacaounico() {

        $this->db->select('distinct(p.nome) as paciente,
            pi.nome as indicacao');
        $this->db->from('tb_paciente p');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao');
        $this->db->join('tb_agenda_exames ae', 'ae.paciente_id = p.paciente_id');
        if ($_POST['indicacao'] != "0") {
            $this->db->where("p.indicacao", $_POST['indicacao']);
        } else {
            $this->db->where("p.indicacao is not null");
        }

        // if ($_POST['grupo_indicacao'] != "0") {
        //     $this->db->where('pi.grupo_id', $_POST['grupo_indicacao']);
        // }

        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('p.nome, pi.nome');
        $this->db->orderby('pi.nome');

        // $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function listacadaindicacao() {

        $this->db->select('pi.nome as indicacao,
                           pi.tipo_id,
                           pi.classe,
                           pi.conta_id,
                           pi.credor_devedor_id');
        $this->db->from('tb_paciente_indicacao pi');
        $this->db->where("pi.paciente_indicacao_id", $_POST['indicacao']);
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioindicacaoexames() {
//        die;
        $this->db->select(' p.nome as paciente, 
                            ae.paciente_id,ae.valor_promotor,ae.percentual_promotor, ae.valor_total,
                            pt.nome as procedimento,
                            ae.data,
                            ae.observacoes,
                            pt.grupo,
                            c.nome as convenio,
                            pi.nome as indicacao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'ae.paciente_id = p.paciente_id');
        $this->db->join('tb_paciente_indicacao pi', 'ae.indicacao = pi.paciente_indicacao_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');

        if ($_POST['indicacao'] != "0") {
            $this->db->where("ae.indicacao", $_POST['indicacao']);
        } else {
            $this->db->where("ae.indicacao is not null");
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['grupo_indicacao'] != "0") {
            $this->db->where('pi.grupo_id', $_POST['grupo_indicacao']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('pi.nome');
        $this->db->orderby('ae.data');
        $return = $this->db->get();
//        var_dump($return->result()); die;
        return $return->result();
    }

    function relatoriopacientewhatsapp() {
        $this->db->select('
                           distinct(p.paciente_id), 
                           p.nome as paciente,
                           p.sexo, 
                           p.cns, 
                           p.nascimento,
                           p.whatsapp,
                           p.celular,
                           p.telefone,
                           p.escolaridade_id,
                           p.estado_civil_id
                           ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'ae.paciente_id = p.paciente_id');

        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }

        $this->db->where("(p.whatsapp IS NOT NULL AND p.whatsapp != '')");
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nascimento desc');
//        $this->db->groupby('p.paciente_id');
        $this->db->orderby('p.sexo');
        $this->db->orderby('p.estado_civil_id');
        $return = $this->db->get();
//        var_dump($return->result()); die;
        return $return->result();
    }

    function relatoriopacienteduplicado() {
        $this->db->select('paciente_id,
                           p.nome as paciente,
                           p.nascimento,
                           p.nome_mae,
                           p.cpf
                           
                           ');
        $this->db->from('tb_paciente p');

        $this->db->where("p.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("p.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['pesquisa'] == '1') {
            $this->db->orderby('p.nome');
        } elseif ($_POST['pesquisa'] == '2') {
            $this->db->where('p.nascimento is not null');
            $this->db->orderby('p.nascimento, p.nome ');
        } elseif ($_POST['pesquisa'] == '3') {
            $this->db->where('p.nome_mae !=', '');
            $this->db->orderby('p.nome_mae,p.nome');
        } elseif ($_POST['pesquisa'] == '4') {
            $this->db->where('p.cpf !=', '');
            $this->db->orderby('p.cpf,p.nome');
        }

//        $this->db->orderby('p.sexo');
//        $this->db->orderby('p.nome_mae');
//        $this->db->orderby('p.cpf');
        $return = $this->db->get();
//        var_dump($return->result()); die;
        return $return->result();
    }

    function relatoriopacientecpfvalido() {
        $this->db->select('paciente_id,
                           p.nome as paciente,
                           p.nascimento,
                           p.nome_mae,
                           p.cpf
                           ');
        $this->db->from('tb_paciente p');

//        $this->db->where("p.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("p.ativo", 't');
        if ($_POST['cpf'] == 'SIM') {
            $this->db->where("p.cpf !=", '');
        }
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioperfilpaciente() {
        $this->db->select('
                           distinct(p.paciente_id), 
                           p.nome as paciente,
                           p.sexo, 
                           p.nascimento,
                           p.escolaridade_id,
                           p.estado_civil_id,
                           c.nome as plano');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'ae.paciente_id = p.paciente_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        if ($_POST['medico'] != "0") {
            $medico = $_POST['medico'];
            $this->db->where("(ae.medico_agenda = {$medico} OR ae.medico_consulta_id = {$medico})");
        }
        if ($_POST['plano'] != "0") {
            $this->db->where("p.convenio_id", $_POST['plano']);
        }

        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nascimento desc');
//        $this->db->groupby('p.paciente_id');
        $this->db->orderby('p.sexo');
        $this->db->orderby('p.estado_civil_id');
        $return = $this->db->get();

        return $return->result();
    }

    function relatoriounicoretorno() {
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $this->db->select("
                           distinct(p.paciente_id), 
                           p.nome as paciente,
                           p.sexo, 
                           p.nascimento,
                           p.escolaridade_id,
                           p.estado_civil_id,
                           c.nome as plano", false);
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'ae.paciente_id = p.paciente_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('ae.realizada', 't');
        $this->db->where('ae.cancelada', 'f');
//        if ($_POST['medico'] != "0") {
//            $medico = $_POST['medico'];
//            $this->db->where("ae.medico_agenda = {$medico} OR ae.medico_consulta_id = {$medico}");
//        }
//        if ($_POST['plano'] != "0") {
//            $this->db->where("p.convenio_id", $_POST['plano']);
//        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('p.nome');
        $this->db->orderby('p.nascimento desc');
        $this->db->groupby('ae.paciente_id');
        $this->db->groupby('p.paciente_id, c.nome');
        $this->db->orderby('p.sexo');
        $this->db->orderby('p.estado_civil_id');
        $return = $this->db->get();
//        var_dump($return->result()); die;
        return $return->result();
    }

    function relatoriounicoretornopaciente($paciente_id) {

        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));

        $this->db->select("al.paciente_id");
        $this->db->from('tb_ambulatorio_laudo al');
//        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("al.paciente_id", $paciente_id);
        $this->db->where("al.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));

        $this->db->limit(1);
        $return = $this->db->get()->result();
        return $return;
    }

    function relatorioperfilpacienteidade() {
        $this->db->select('
                           distinct(p.nascimento), 
                           
                           ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'ae.paciente_id = p.paciente_id');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('p.nascimento');
//        $this->db->orderby('p.sexo');
//        $this->db->orderby('p.estado_civil_id');
        $return = $this->db->get();
//        var_dump($return->result()); die;
        return $return->result();
    }

    function relatorioindicacaoexamesconsolidado() {

        $this->db->select('pi.nome as indicacao,
            count(pi.nome) as quantidade');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'ae.paciente_id = p.paciente_id');
        $this->db->join('tb_paciente_indicacao pi', 'ae.indicacao = pi.paciente_indicacao_id');
        if ($_POST['indicacao'] != "0") {
            $this->db->where("ae.indicacao", $_POST['indicacao']);
        } else {
            $this->db->where("ae.indicacao is not null");
        }

        if ($_POST['grupo_indicacao'] != "0") {
            $this->db->where('pi.grupo_id', $_POST['grupo_indicacao']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->groupby('pi.nome');
//        $this->db->orderby('ae.data');
//        $this->db->orderby('ae.data');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorionotafiscal($guia = null) {
        $inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));

        $this->db->select('distinct(g.ambulatorio_guia_id ),
                            data_criacao,
                            g.valor_guia,
                            g.checado,
                            g.numero_nota_fiscal,
                            sum(ae.valor_total) as total,
                            p.nome as paciente,
                            p.paciente_id,
                            g.nota_fiscal,
                            p.celular,
                            p.cpf,
                            p.rg,
                            p.telefone
                            ');
        $this->db->from('tb_ambulatorio_guia g');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = g.paciente_id', 'left');

        if ($guia == "NAO") {
            $this->db->where('g.nota_fiscal', 't');
        }
        if ($_POST['empresa'] != '0') {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->where('ae.data >=', $inicio);
        $this->db->where('ae.data <=', $fim);
        $this->db->groupby('g.ambulatorio_guia_id');
        $this->db->groupby('p.celular');
        $this->db->groupby('p.telefone');
        $this->db->groupby('p.nome');
        $this->db->groupby('p.paciente_id');
        $this->db->groupby('p.cpf');
        $this->db->groupby('p.rg');
        $this->db->orderby('data_criacao');
        $this->db->orderby('p.nome');

        $return = $this->db->get();
        return $return->result();
    }

    function listarnotasfiscais() {
        $inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_GET['txtdata_inicio'])));
        $fim = date("Y-m-d", strtotime(str_replace('/', '-', $_GET['txtdata_fim'])));

        $this->db->select('distinct(g.ambulatorio_guia_id ),
                            data_criacao,
                            g.valor_guia,
                            g.checado,
                            g.numero_nota_fiscal,
                            sum(ae.valor_total) as total,
                            p.nome as paciente,
                            p.paciente_id,
                            p.celular,
                            p.cpf,
                            p.rg,
                            p.telefone
                            ');
        $this->db->from('tb_ambulatorio_guia g');
        $this->db->join('tb_agenda_exames ae', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = g.paciente_id', 'left');

        if ($_GET['guia'] == "NAO") {
            $this->db->where('g.nota_fiscal', 't');
        }
        if ($_GET['empresa'] != '0') {
            $this->db->where('ae.empresa_id', $_GET['empresa']);
        }
        $this->db->where('ae.data >=', $inicio);
        $this->db->where('ae.data <=', $fim);
        $this->db->groupby('g.ambulatorio_guia_id');
        $this->db->groupby('p.celular');
        $this->db->groupby('p.telefone');
        $this->db->groupby('p.nome');
        $this->db->groupby('p.paciente_id');
        $this->db->groupby('p.cpf');
        $this->db->groupby('p.rg');
        $this->db->orderby('data_criacao');
        $this->db->orderby('p.nome');

        $return = $this->db->get();
        return $return->result();
    }

    function procedimentoguianota($ambulatorio_guia_id) {

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
                            ae.valor,
                            ae.valor1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.realizada,
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
                            pt.nome as procedimento,
                            o.nome,
                            e.exames_id,
                            op.nome as nomefaturamento,
                            ae.operador_faturamento,
                            f.nome as forma_pagamento,
                            f2.nome as forma_pagamento_2,
                            f3.nome as forma_pagamento_3,
                            f4.nome as forma_pagamento_4,
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
        $this->db->where('ae.guia_id', $ambulatorio_guia_id);
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

        if ($_POST['grupo_indicacao'] != "0") {
            $this->db->where('pi.grupo_id', $_POST['grupo_indicacao']);
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

    function relatorioindicacaounicoconsolidado() {

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

        // if ($_POST['grupo_indicacao'] != "0") {
        //     $this->db->where('pi.grupo_id', $_POST['grupo_indicacao']);
        // }

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
        $data = date("Y-m-d");
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
        $this->db->where('ae.procedimento_tuss_id is not null');
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
        $data = date("Y-m-d");
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

        $this->db->where('ae.data <=', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.procedimento_tuss_id is not null');
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
        $data = date("Y-m-d");
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
        $this->db->where('ae.procedimento_tuss_id is not null');
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
        $data = date("Y-m-d");
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
        $this->db->where('ae.procedimento_tuss_id is not null');
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
        $this->db->where('ae.procedimento_tuss_id is not null');
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

        $this->db->where('ae.empresa_id', $empresa_id);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.confirmado', 'f');
        $this->db->where('ae.tipo', 'EXAME');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.procedimento_tuss_id is not null');
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
        $data = date("Y-m-d");
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
        $this->db->where('ae.procedimento_tuss_id is not null');
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
        $data = date("Y-m-d");
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
        $this->db->where('ae.procedimento_tuss_id is not null');
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
        $data = date("Y-m-d");
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
        $this->db->where('ae.procedimento_tuss_id is not null');
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
        $data = date("Y-m-d");
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
        $this->db->where('ae.procedimento_tuss_id is not null');
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
        $this->db->where('ae.procedimento_tuss_id is not null');


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
        $this->db->where('ae.procedimento_tuss_id is not null');
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
            pc.convenio_id,
            ae.autorizacao,
            ae.valor_medico,
            ae.percentual_medico,
            ae.valor_total,
            ae.valor_revisor,
            ae.percentual_revisor,
            ae.valor_promotor,
            ae.agenda_exames_id,
            al.ambulatorio_laudo_id,
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

        $mes_incial = date("z", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) + 1;
        $mes_final = date("z", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) + 1;
        $sql = "SELECT p.nome as paciente, p.nascimento , p.celular , p.cns , p.telefone 
                FROM ponto.tb_paciente p
                LEFT JOIN ponto.tb_convenio c ON c.convenio_id = p.convenio_id
                WHERE (Extract(DOY From p.nascimento) >= $mes_incial) AND (Extract(DOY From p.nascimento) <= $mes_final)
                ORDER BY Extract(Month From p.nascimento), Extract(Day From p.nascimento), Extract(Year From p.nascimento),p.nome ";
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
        $this->db->select('mc.valor, mc.percentual');
        $this->db->from('tb_procedimento_percentual_medico_convenio mc');
        $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
        $this->db->where('m.procedimento_tuss_id', $procedimentopercentual);
        $this->db->where('mc.medico', $medicopercentual);
        $this->db->where('mc.ativo', 'true');
        $return = $this->db->get();

        return $return->result();
    }

    function listarprocedimentopreparo() {
        $this->db->select('pt.sala_preparo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->where('pc.procedimento_convenio_id', $_POST['txtprocedimento_tuss_id']);
        $this->db->where('pc.ativo', 'true');
        $return = $this->db->get();

        return $return->result();
    }

    function percentualmedicoconvenioexames($procedimentopercentual, $medicopercentual) {
        $this->db->select('mc.valor as perc_medico, mc.percentual');
        $this->db->from('tb_procedimento_percentual_medico_convenio mc');
        $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
        $this->db->where('m.procedimento_tuss_id', $procedimentopercentual);
        $this->db->where('mc.medico', $medicopercentual);
        $this->db->where('mc.ativo', 'true');
        $this->db->where('mc.revisor', 'false');
        $return = $this->db->get();

        return $return->result();
    }

    function percentualmedicoprocedimento($procedimentopercentual) {

        $this->db->select('pt.perc_medico, pt.percentual, pc.procedimento_convenio_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->where('pc.procedimento_convenio_id', $procedimentopercentual);
//        $this->db->where('pc.ativo', 'true');
//        $this->db->where('pt.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function percentualmedicoprocedimento2($procedimentopercentual) {

        $this->db->select('pt.perc_medico, pt.percentual, pc.procedimento_convenio_id');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->where('pc.procedimento_convenio_id', $procedimentopercentual);
//        $this->db->where('pc.ativo', 'true');
//        $this->db->where('pt.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function percentuallaboratorioconvenioexames($procedimentopercentual) {
//        var_dump($procedimentopercentual);
        $this->db->select('mc.valor as perc_laboratorio, mc.percentual, mc.laboratorio');
        $this->db->from('tb_procedimento_percentual_laboratorio_convenio mc');
        $this->db->join('tb_procedimento_percentual_laboratorio m', 'm.procedimento_percentual_laboratorio_id = mc.procedimento_percentual_laboratorio_id', 'left');
        $this->db->where('m.procedimento_tuss_id', $procedimentopercentual);
//        $this->db->where('mc.laboratorio', $laboratoriopercentual);
        $this->db->where('mc.ativo', 'true');
//        $this->db->where('mc.revisor', 'false');
        $return = $this->db->get();

        return $return->result();
    }

    function percentuallaboratorioprocedimento($procedimentopercentual) {

        $this->db->select('pt.perc_laboratorio, pt.percentual');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
        $this->db->where('pc.procedimento_convenio_id', $procedimentopercentual);
//        $this->db->where('pc.ativo', 'true');
//        $this->db->where('pt.ativo', 'true');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioprocedimentoatendimentomensal() {

        $this->db->select(' SUM(ae.quantidade) as qtde,
                            pt.nome as procedimento,
                            pt.procedimento_tuss_id');
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
        $this->db->where('ae.paciente_id is not null');
        $this->db->where('pt.home_care', 'f');

        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['revisor'] != "0") {
            $this->db->where('al.medico_parecer2', $_POST['revisor']);
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


//        $periodo = explode("/", $_POST["periodo_inicio"]);
//        $mes = $periodo[0];
//        $ano = $periodo[1];
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST["periodo_inicio"])));

//        $periodo = explode("/", $_POST["periodo_fim"]);
//        $mes = $periodo[0];
//        $ano = $periodo[1];
        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST["periodo_fim"])));

//        $this->db->where("( ( EXTRACT(month FROM al.data) = {$mes} ) AND ( EXTRACT(year FROM al.data) = {$ano}) )");
        $this->db->where("al.data >= '$data_inicio'");
        $this->db->where("al.data <= '$data_fim'");

        $this->db->groupby('pt.nome, pt.procedimento_tuss_id');

        $this->db->orderby('pt.nome');
//        $this->db->orderby('al.medico_parecer1');

        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoprocedimentoatendimentomensal() {

        $this->db->select(' SUM(ae.quantidade) as total,
                            pt.nome as procedimento,
                            pt.procedimento_tuss_id,
                            al.medico_parecer1,
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
        $this->db->join('tb_operador ops', 'ops.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('ae.paciente_id is not null');
        $this->db->where('pt.home_care', 'f');

        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['revisor'] != "0") {
            $this->db->where('al.medico_parecer2', $_POST['revisor']);
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
//        $periodo = explode("/", $_POST["periodo_inicio"]);
//        $mes = $periodo[0];
//        $ano = $periodo[1];
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST["periodo_inicio"])));

//        $periodo = explode("/", $_POST["periodo_fim"]);
//        $mes = $periodo[0];
//        $ano = $periodo[1];
        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST["periodo_fim"])));

//        $this->db->where("( ( EXTRACT(month FROM al.data) = {$mes} ) AND ( EXTRACT(year FROM al.data) = {$ano}) )");
        $this->db->where("al.data >= '$data_inicio'");
        $this->db->where("al.data <= '$data_fim'");

        $this->db->groupby('al.medico_parecer1, op.nome, pt.nome, pt.procedimento_tuss_id');

        $this->db->orderby('pt.nome');
        $this->db->orderby('al.medico_parecer1');

        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoatendimentomensal() {

        $this->db->select('op.nome as medico, al.medico_parecer1');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('ae.paciente_id is not null');
        $this->db->where('pt.home_care', 'f');

        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['revisor'] != "0") {
            $this->db->where('al.medico_parecer2', $_POST['revisor']);
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

//        echo "<pre>";
//        var_dump($_POST["periodo_inicio"]); die;
//        $periodo = explode("/", $_POST["periodo_inicio"]);
//        $mes = $periodo[0];
//        $ano = $periodo[1];
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST["periodo_inicio"])));

//        $periodo = explode("/", $_POST["periodo_fim"]);
//        $mes = $periodo[0];
//        $ano = $periodo[1];
        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST["periodo_fim"])));

//        $this->db->where("( ( EXTRACT(month FROM al.data) = {$mes} ) AND ( EXTRACT(year FROM al.data) = {$ano}) )");
        $this->db->where("al.data >= '$data_inicio'");
        $this->db->where("al.data <= '$data_fim'");

        $this->db->groupby('op.nome, al.medico_parecer1');

        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniofinanceiro() {

        $this->db->select("ae.quantidade,
                            p.nome as paciente,
                            pt.nome as procedimento,
                            pc.procedimento_convenio_id,
                            ae.autorizacao,
                            ae.agenda_exames_id,
                            ae.percentual_medico,
                            ae.valor_medico,
                            ae.percentual_laboratorio,
                            ae.valor_laboratorio,
                            ae.laboratorio_id,
                            lab.nome as laboratorio,
                            ae.percentual_promotor,
                            ae.valor_promotor,
                            ae.desconto_ajuste1,
                            ae.desconto_ajuste2,
                            ae.desconto_ajuste3,
                            ae.desconto_ajuste4,
                            ae.data,
                            ae.producao_paga,
                            al.data as data_laudo,
                            al.data_producao,
                            al.ambulatorio_laudo_id,
                            ae.data_antiga,
                            ae.sala_pendente,
                            e.situacao,
                            op.operador_id,
                            ae.valor,
                            ae.valor1,
                            ae.valor2,
                            ae.valor3,
                            ae.valor4,
                            ae.valor_total,
                            pc.procedimento_tuss_id,
                            al.medico_parecer1,
                            pt.grupo,
                            pt.perc_medico,
                            (
                                SELECT dia_recebimento 
                                FROM ponto.tb_procedimento_percentual_medico_convenio ppmc
                                INNER JOIN ponto.tb_procedimento_percentual_medico ppm 
                                ON ppm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id
                                WHERE ppm.procedimento_tuss_id = ae.procedimento_tuss_id
                                AND ppm.ativo = 't'
                                AND ppmc.ativo = 't'
                                AND ppmc.medico = al.medico_parecer1
                                ORDER BY ppmc.data_cadastro DESC
                                LIMIT 1
                            ) as dia_recebimento,
                            (
                                SELECT tempo_recebimento 
                                FROM ponto.tb_procedimento_percentual_medico_convenio ppmc
                                INNER JOIN ponto.tb_procedimento_percentual_medico ppm 
                                ON ppm.procedimento_percentual_medico_id = ppmc.procedimento_percentual_medico_id
                                WHERE ppm.procedimento_tuss_id = ae.procedimento_tuss_id
                                AND ppm.ativo = 't'
                                AND ppmc.ativo = 't'
                                AND ppmc.medico = al.medico_parecer1
                                ORDER BY ppmc.data_cadastro DESC
                                LIMIT 1
                            ) as tempo_recebimento,
                            al.situacao as situacaolaudo,
                            tu.classificacao,
                            o.nome as revisor,
                            op.taxa_administracao,
                            pt.percentual,
                            op.nome as medico,
                            pi.nome as indicacao,
                            ops.nome as medicosolicitante,
                            c.nome as convenio,
                            c.iss,
                            ae.valor1,
                            ae.forma_pagamento as forma_pagamento1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.forma_pagamento3,
                            ae.valor3,
                            ae.numero_sessao,
                            ae.forma_pagamento4,
                            ae.valor4,
                            f.nome as forma_pagamento_1,
                            f.cartao as cartao1,
                            f2.nome as forma_pagamento_2,
                            f2.cartao as cartao2,
                            f3.nome as forma_pagamento_3,
                            f3.cartao as cartao3,
                            f4.nome as forma_pagamento_4,
                            f4.cartao as cartao4");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = ae.indicacao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_laboratorio lab', 'lab.laboratorio_id = ae.laboratorio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer2', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador ops', 'ops.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = ae.forma_pagamento4', 'left');
        $this->db->where('e.cancelada', 'false');
//        $this->db->where('ae.valor_medico is not null');
        $this->db->where('ae.paciente_id is not null');
        $this->db->where('pt.home_care', 'f');

        if ($_POST['situacao'] == "1") {
            $this->db->where('al.situacao', 'FINALIZADO');
        } elseif ($_POST['situacao'] == "0") {
            $this->db->where('al.situacao !=', 'FINALIZADO');
        }

        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['revisor'] != "0") {
            $this->db->where('al.medico_parecer2', $_POST['revisor']);
        }
        if ($_POST['convenio'] != "0" && $_POST['convenio'] != "") {
            $this->db->where("pc.convenio_id", $_POST['convenio']);
        }
        if ($_POST['sala_id'] != "0") {
            $this->db->where('ae.agenda_exames_nome_id', $_POST['sala_id']);
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




        $this->db->where("al.data_producao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("al.data_producao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['ordem'] == '1') {
            $this->db->orderby('ae.data');
            $this->db->orderby('ae.data_autorizacao');
            $this->db->orderby('ae.ordenador desc');
//            $this->db->orderby('ae.paciente_id');
        } else {
            $this->db->orderby('al.medico_parecer1');
            $this->db->orderby('pc.convenio_id');
            $this->db->orderby('ae.data');
            $this->db->orderby('ae.paciente_id');
        }

        $return = $this->db->get();
        return $return->result();
    }

    function relatoriolaboratorioconveniofinanceiro() {

        $this->db->select("ae.quantidade,
                            p.nome as paciente,
                            pt.nome as procedimento,
                            pc.procedimento_convenio_id,
                            ae.autorizacao,
                            ae.percentual_laboratorio,
                            ae.valor_laboratorio,
                            ae.data,
                            al.data as data_laudo,
                            al.data_producao,
                            ae.data_antiga,
                            ae.sala_pendente,
                            e.situacao,
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
                            al.situacao as situacaolaudo,
                            tu.classificacao,
                            lab.nome as laboratorio,
                            pi.nome as indicacao,
                            ops.nome as medicosolicitante,
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
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = ae.indicacao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_laboratorio lab', 'lab.laboratorio_id = ae.laboratorio_id', 'left');
        $this->db->join('tb_operador ops', 'ops.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->where('e.cancelada', 'false');
//        $this->db->where('ae.valor_laboratorio is not null');
        $this->db->where('ae.paciente_id is not null');
        $this->db->where('pt.home_care', 'f');

        if ($_POST['situacao'] == "1") {
            $this->db->where('al.situacao', 'FINALIZADO');
        } elseif ($_POST['situacao'] == "0") {
            $this->db->where('al.situacao !=', 'FINALIZADO');
        }

        if ($_POST['laboratorios'] != "0") {
            $this->db->where('ae.laboratorio_id', $_POST['laboratorios']);
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

        $this->db->where("al.data_producao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("al.data_producao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['ordem'] == '1') {
            $this->db->orderby('ae.data');
            $this->db->orderby('ae.data_autorizacao');
            $this->db->orderby('ae.ordenador desc');
//            $this->db->orderby('ae.paciente_id');
        } else {
            $this->db->orderby('ae.laboratorio_id');
            $this->db->orderby('pc.convenio_id');
            $this->db->orderby('ae.data');
            $this->db->orderby('ae.paciente_id');
        }

        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniofinanceirohomecare() {

        $this->db->select('ae.quantidade,
            p.nome as paciente,
            pt.nome as procedimento,
            pc.procedimento_convenio_id,
            ae.autorizacao,
            ae.percentual_medico,
            ae.valor_medico,
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
            pi.nome as indicacao,
            ae.percentual_promotor,
            ae.valor_promotor,
            op.nome as medico,
            ops.nome as medicosolicitante,
            c.nome as convenio,
            c.iss');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = ae.indicacao', 'left');
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
        $this->db->where('pt.home_care', 't');
        $this->db->where('ae.paciente_id is not null');

        if ($_POST['situacao'] == "1") {
            $this->db->where('al.situacao', 'FINALIZADO');
        } elseif ($_POST['situacao'] == "0") {
            $this->db->where('al.situacao !=', 'FINALIZADO');
        }
        if ($_POST['sala_id'] != "0") {
            $this->db->where('ae.agenda_exames_nome_id', $_POST['sala_id']);
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




        $this->db->where("ae.data_faturamento >=", date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'] . " 00:00:00"))));
        $this->db->where("ae.data_faturamento <=", date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['txtdata_fim'] . " 23:59:59"))));


        $this->db->orderby('al.medico_parecer1');
        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.paciente_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioresumocirurgicomedicoconvenio() {

        $this->db->select('sum(ae.valor_total) as valor,
                            sum(ae.quantidade) as quantidade,
                            o.nome as medico');
        $this->db->from('tb_agenda_exame_equipe aee');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = aee.funcao', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = aee.agenda_exames_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = aee.operador_responsavel', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->where('ae.tipo', 'CIRURGICO');

        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioresumocirurgicomedicotodos() {

        $this->db->select('sum(ae.valor_total) as valor,
                           ae.guia_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where('ae.tipo', 'CIRURGICO');

        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('ae.guia_id');
        $this->db->orderby('ae.guia_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioresumocirurgicomedico() {

        $this->db->select('sum(aee.valor) as valor_medico,
                           sum(ae.valor_total) as valor,
                           o.nome as medico,
                           gp.descricao as funcao,
                           ae.guia_id');
        $this->db->from('tb_agenda_exame_equipe aee');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = aee.funcao', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = aee.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_guia ag', 'ag.ambulatorio_guia_id = ae.guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = aee.operador_responsavel', 'left');
        $this->db->where('ae.tipo', 'CIRURGICO');

        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('o.nome, gp.descricao, ae.guia_id');
        $this->db->orderby('ae.guia_id');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocirurgicomedicoconveniofinanceirotodos() {

        $this->db->select('sum(ae.valor_total) as valor,
                            sum(ae.quantidade) as quantidade,
                            o.nome as medico');
        $this->db->from('tb_agenda_exame_equipe aee');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = aee.funcao', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = aee.agenda_exames_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = aee.operador_responsavel', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->where('ae.tipo', 'CIRURGICO');
        $this->db->where('pt.home_care', 'f');

        if ($_POST['medicos'] != "0") {
            $this->db->where('aee.operador_responsavel', $_POST['medicos']);
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

        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocirurgicomedicoconveniofinanceiro() {

        $this->db->select('aee.valor as valor_medico,
                           o.nome as medico,
                           c.nome as convenio,
                           pt.nome as procedimento,
                           p.nome as paciente,
                           ae.valor_total,
                           ae.data,
                           gp.descricao as funcao,
                           ae.guia_id');
        $this->db->from('tb_agenda_exame_equipe aee');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = aee.funcao', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = aee.agenda_exames_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = aee.operador_responsavel', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->where('ae.tipo', 'CIRURGICO');
        $this->db->where('pt.home_care', 'f');

        if ($_POST['medicos'] != "0") {
            $this->db->where('aee.operador_responsavel', $_POST['medicos']);
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

//        $this->db->groupby('op.nome');
//        $this->db->orderby('op.nome');
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
//        $this->db->where('ae.valor_medico is not null');
        $this->db->where('pt.home_care', 'f');

        if ($_POST['situacao'] == "1") {
            $this->db->where('al.situacao', 'FINALIZADO');
        } elseif ($_POST['situacao'] == "0") {
            $this->db->where('al.situacao !=', 'FINALIZADO');
        }

        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['sala_id'] != "0") {
            $this->db->where('ae.agenda_exames_nome_id', $_POST['sala_id']);
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

    function relatoriolaboratorioconveniofinanceirotodos() {

        $this->db->select('sum(ae.valor_total)as valor,
            sum(ae.quantidade) as quantidade,
            lab.nome as laboratorio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_laboratorio lab', 'lab.laboratorio_id = ae.laboratorio_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_convenio_grupo cg', 'cg.convenio_grupo_id = c.convenio_grupo_id', 'left');
        $this->db->where('e.cancelada', 'false');
//        $this->db->where('ae.valor_laboratorio is not null');
        $this->db->where('pt.home_care', 'f');

        if ($_POST['situacao'] == "1") {
            $this->db->where('al.situacao', 'FINALIZADO');
        } elseif ($_POST['situacao'] == "0") {
            $this->db->where('al.situacao !=', 'FINALIZADO');
        }

        if ($_POST['laboratorios'] != "0") {
            $this->db->where('ae.laboratorio_id', $_POST['laboratorios']);
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

        $this->db->groupby('lab.nome');
        $this->db->orderby('lab.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniofinanceirohomecaretodos() {

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
        $this->db->where('pt.home_care', 't');

        if ($_POST['situacao'] == "1") {
            $this->db->where('al.situacao', 'FINALIZADO');
        } elseif ($_POST['situacao'] == "0") {
            $this->db->where('al.situacao !=', 'FINALIZADO');
        }
        if ($_POST['sala_id'] != "0") {
            $this->db->where('ae.agenda_exames_nome_id', $_POST['sala_id']);
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




        $this->db->where("ae.data_faturamento >=", date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'] . " 00:00:00"))));
        $this->db->where("ae.data_faturamento <=", date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['txtdata_fim'] . " 23:59:59"))));


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
            op.taxa_administracao,
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
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador ops', 'ops.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.procedimento_tuss_id is not null');
//        $this->db->where('al.situacao', 'FINALIZADO');
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
                           sum(ae.valor_total) as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where("ae.valor_medico is not null");
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

    function relatorioresumolaboratoriogeral() {

        $this->db->select('ae.laboratorio_id, lab.nome as laboratorio,
                           sum(ae.valor_total) as valor');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_laboratorio lab', 'lab.laboratorio_id = ae.laboratorio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->where('e.cancelada', 'false');
        $this->db->where("ae.valor_medico is not null");
        $this->db->where("ae.laboratorio_id is not null");
        //$this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }

        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $this->db->groupby('ae.laboratorio_id,lab.nome');
        $this->db->orderby('lab.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorioresumogeralmedico() {

        $this->db->select('op.nome as medico,
                           ae.laboratorio_id,
                           ae.valor_total,
                           ae.valor_medico,
                           ae.quantidade,
                           ae.valor_laboratorio,
                           ae.forma_pagamento,
                           ae.forma_pagamento2,
                           ae.forma_pagamento3,
                           ae.forma_pagamento4,
                           ae.valor1,
                           ae.valor2,
                           ae.valor3,
                           ae.valor4,
                           c.dinheiro,
                           c.nome,
                           ae.percentual_medico,
                           pt.perc_medico,
                           ae.percentual_laboratorio,
                           pt.procedimento_tuss_id,
                           al.medico_parecer1,
                           pt.percentual');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_laboratorio lab', 'lab.laboratorio_id = ae.laboratorio_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('ae.valor_medico is not null');
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

    function relatorioresumocredito() {

        $this->db->select("op.nome as medico,
                           ae.valor_total,
                           p.nome as paciente,
                           ae.valor_medico,
                           ae.forma_pagamento,
                           ae.forma_pagamento2,
                           ae.forma_pagamento3,
                           ae.forma_pagamento4,
                           ae.valor1,
                           ae.valor2,
                           ae.valor3,
                           ae.valor4,
                           (
                            SELECT SUM(pcr.valor) FROM ponto.tb_paciente_credito pcr WHERE pcr.ativo = 't' AND pcr.paciente_id = p.paciente_id
                           ) as saldo_credito,
                           (
                            SELECT data_cadastro FROM ponto.tb_paciente_credito pc2 WHERE pc2.ativo = 't' AND pc2.paciente_id = p.paciente_id AND pc2.valor > 0 ORDER BY data_cadastro DESC LIMIT 1
                           ) AS data_lancamento,
                           c.dinheiro,
                           c.nome,
                           ae.percentual_medico,
                           pt.perc_medico,
                           pt.nome as procedimento,
                           ae.data,
                           pt.procedimento_tuss_id,
                           al.medico_parecer1,
                           pt.percentual");
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('e.cancelada', 'false');
        $this->db->where('ae.valor_medico is not null');
        $this->db->where('(ae.forma_pagamento = 1000 OR ae.forma_pagamento2 = 1000 OR ae.forma_pagamento3 = 1000 OR ae.forma_pagamento4 = 1000)');
//        $this->db->where('ppm.ativo', 'true');
        //$this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }




        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocreditopacientes() {

        $this->db->select('pac.paciente_id, 
                           p.nome as paciente, 
                           p.telefone, 
                           p.celular, 
                           SUM(pac.valor) AS saldo');
        $this->db->from('tb_paciente_credito pac');
        $this->db->join('tb_paciente p', 'p.paciente_id = pac.paciente_id', 'left');
        $this->db->where("pac.ativo = 't'");
        if ($_POST['txtNome'] != "") {
            $this->db->where("p.nome ilike", "%" . $_POST['txtNome'] . "%");
        }
        $this->db->groupby("pac.paciente_id, 
                            p.telefone, 
                            p.celular,
                            p.nome 
                            HAVING SUM(pac.valor) > 0");

        $this->db->orderby("p.nome");


        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocreditosaldo($paciente_id) {

        $this->db->select('pac.data_cadastro,
                           p.nome as paciente,
                           pac.valor,
                           pt.perc_medico,
                           pt.procedimento_tuss_id,
                           pt.nome as procedimento,
                           pt.percentual');
        $this->db->from('tb_paciente_credito pac');
        $this->db->join('tb_paciente p', 'p.paciente_id = pac.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pac.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');

        $this->db->where("pac.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where("pac.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        $this->db->where("pac.valor > 0");

        if ($_POST['txtNome'] != "") {
            $this->db->where("p.nome ilike", "%" . $_POST['txtNome'] . "%");
        }

//        $this->db->orderby("p.nome");
        $this->db->orderby("pac.data_cadastro");


        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocredito() {

        $this->db->select('pac.data_cadastro,
                           p.nome as paciente,
                           pac.valor,
                           pt.perc_medico,
                           pt.procedimento_tuss_id,
                           pt.nome as procedimento,
                           pt.percentual');
        $this->db->from('tb_paciente_credito pac');
        $this->db->join('tb_paciente p', 'p.paciente_id = pac.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pac.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');

        $this->db->where("pac.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where("pac.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");
        $this->db->where("pac.valor > 0");

        if ($_POST['txtNome'] != "") {
            $this->db->where("p.nome ilike", "%" . $_POST['txtNome'] . "%");
        }

//        $this->db->orderby("p.nome");
        $this->db->orderby("pac.data_cadastro");
//        $this->db->orderby("pt.nome");


        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocreditoestorno() {

        $this->db->select('per.data_cadastro as data_estorno,
                           o.nome as operador_estorno,
                           per.data as data_credito,
                           p.nome as paciente,
                           per.valor,
                           per.justificativa,
                           e.nome as empresa,
                           pt.nome as procedimento,
                           per.financeiro_fechado,
                           per.data_financeiro,
                           f1.nome as formapagamento1,
                           valor1,
                           f2.nome as formapagamento2,
                           valor2,
                           f3.nome as formapagamento3,
                           valor3,
                           f4.nome as formapagamento4,
                           valor4');
        $this->db->from('tb_paciente_estorno_registro per');
        $this->db->join('tb_paciente p', 'p.paciente_id = per.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = per.operador_cadastro', 'left');
        $this->db->join('tb_empresa e', 'e.empresa_id = per.empresa_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = per.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_forma_pagamento f1', 'f1.forma_pagamento_id = per.forma_pagamento1', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = per.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = per.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = per.forma_pagamento4', 'left');

        $this->db->where("per.data_cadastro >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . " 00:00:00");
        $this->db->where("per.data_cadastro <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . " 23:59:59");

        if ($_POST['operador_id'] != '') {
            $this->db->where("per.operador_cadastro", $_POST['operador']);
        }
        if ($_POST['empresa'] != '') {
            $this->db->where("per.empresa_id", $_POST['empresa']);
        }

        $this->db->orderby("per.data_cadastro");

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
//        $this->db->where('ae.valor_medico is not null');
        $this->db->where('ae.paciente_id is not null');
//        $this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['medicos'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medicos']);
        }
        if ($_POST['revisor'] != "0") {
            $this->db->where('al.medico_parecer2', $_POST['revisor']);
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
        if ($_POST['sala_id'] != "0") {
            $this->db->where('ae.agenda_exames_nome_id', $_POST['sala_id']);
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }

        $this->db->where("al.data_producao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("al.data_producao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        $return = $this->db->count_all_results();
        return $return;
    }

    function relatoriolaboratorioconveniocontadorfinanceiro() {

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
//        $this->db->where('ae.valor_laboratorio is not null');
        $this->db->where('ae.paciente_id is not null');
//        $this->db->where('al.situacao', 'FINALIZADO');
        if ($_POST['laboratorios'] != "0") {
            $this->db->where('ae.laboratorio_id', $_POST['laboratorios']);
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

        $this->db->where("al.data_producao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("al.data_producao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

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

    function relatoriocaixapersonalizado() {
        $this->db->select('ag.ambulatorio_guia_id');
        $this->db->from('tb_ambulatorio_guia ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = ag.convenio_id', 'left');
        if ($_POST['txtNomeid'] != '') {
            $this->db->where("ag.paciente_id", $_POST['txtNomeid']);
        }

        if ($_POST['empresa'] != '0' && $_POST['empresa'] != '') {
            $this->db->where("ag.empresa_id", $_POST['empresa']);
        }

        $this->db->where('c.dinheiro', "t");
        $this->db->where("ag.data_criacao >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ag.data_criacao <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixapersonalizadooperadores() {
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $sql = '';
        $grupo = $_POST['grupo'];
        if ($_POST['grupo'] == "1") {
            $sql .= " AND pt.grupo != 'RM'";
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $sql .= " AND pt.grupo = " . "'$grupo'";
        }
        if ($_POST['procedimentos'] != "0") {
            $sql .= " AND pt.procedimento_tuss_id = " . $_POST['procedimentos'];
        }
        if ($_POST['grupomedico'] != "0") {
            $sql .= " AND ogm.operador_grupo_id = " . $_POST['grupomedico'];
            $sql .= " AND ogm.ativo = 't'";
        }
        if ($_POST['medico'] != "0") {
            $sql .= " AND ae.medico_consulta_id = " . $_POST['medico'];
        }
        if ($_POST['txtNome'] != '') {
            $sql .= " AND p.nome ilike '%" . $_POST['txtNome'] . "%'";
        }
        if ($_POST['empresa'] != '0' && $_POST['empresa'] != '') {
            $sql .= " AND ae.empresa_id = " . $_POST['empresa'];
        }
        if ($_POST['operador'] != '0' && $_POST['operador'] != '') {
            $sql .= " AND ae.operador_faturamento = " . $_POST['operador'];
        }
        if ($_POST['forma_pagamento'] == "1") {
            $sql .= " AND ((f.cartao = 't') OR (f2.cartao = 't') OR (f3.cartao = 't') OR (f4.cartao = 't'))";
        }
//        

        $this->db->select('o.operador_id, o.nome');
        $this->db->from('tb_operador o');
        $this->db->where("o.operador_id IN 
                            (
                            SELECT DISTINCT(ae.operador_faturamento) FROM ponto.tb_agenda_exames ae
                            LEFT JOIN ponto.tb_paciente p ON p.paciente_id = ae.paciente_id
                            LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id
                            LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id
                            LEFT JOIN ponto.tb_operador_grupo_medico ogm ON ae.medico_consulta_id = ogm.operador_id
                            LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id
                            LEFT JOIN ponto.tb_forma_pagamento f ON f.forma_pagamento_id = ae.forma_pagamento
                            LEFT JOIN ponto.tb_forma_pagamento f2 ON f2.forma_pagamento_id = ae.forma_pagamento2
                            LEFT JOIN ponto.tb_forma_pagamento f3 ON f3.forma_pagamento_id = ae.forma_pagamento3
                            LEFT JOIN ponto.tb_forma_pagamento f4 ON f4.forma_pagamento_id = ae.forma_pagamento4
                            WHERE ae.data >= '{$data_inicio}' AND ae.data <= '{$data_fim}'
                            AND ae.confirmado = 't' AND ae.operador_autorizacao > 0
                            AND c.dinheiro = 't'
                            {$sql}
                            )");

        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatorionotaprocedimentosvalortotal($guia_id) {

        $this->db->select('sum(ae.quantidade * ae.valor) as valor_total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("ae.guia_id", $guia_id);
//        $this->db->where('g.nota_fiscal', 't');
        $this->db->where('ae.empresa_id', '1');
        $return = $this->db->get()->result();
        return $return[0]->valor_total;
    }

    function relatoriocaixapersonalizadoprocedimentosvalortotal($guia_id, $operador_faturamento) {

        $this->db->select('sum(ae.quantidade * ae.valor) as valor_total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');

        $this->db->where("ae.guia_id", $guia_id);

        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.operador_autorizacao >', 0);

        if ($_POST['txtNomeid'] != '') {
            $this->db->where("ae.paciente_id", $_POST['txtNomeid']);
        }

        if ($_POST['empresa'] != '0' && $_POST['empresa'] != '') {
            $this->db->where("ae.empresa_id", $_POST['empresa']);
        }

        if ($operador_faturamento != '') {
            $this->db->where("ae.operador_faturamento", $operador_faturamento);
        }
        $this->db->where('c.dinheiro', "t");
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $return = $this->db->get()->result();
        return $return[0]->valor_total;
    }

    function relatoriocaixacartaopersonalizadoprocedimentosvalortotal($guia_id) {

        $this->db->select('sum(ae.quantidade * ae.valor) as valor_total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = ae.forma_pagamento4', 'left');
        $this->db->where("((f.cartao = 't') OR (f2.cartao = 't') OR (f3.cartao = 't') OR (f4.cartao = 't'))");

        $this->db->where("ae.guia_id", $guia_id);

        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.operador_autorizacao >', 0);

        if ($_POST['empresa'] != '0' && $_POST['empresa'] != '') {
            $this->db->where("ae.empresa_id", $_POST['empresa']);
        }

        if ($_POST['operador'] != '0' && $_POST['operador'] != '') {
            $this->db->where("ae.operador_faturamento", $_POST['operador']);
        }
        $this->db->where('c.dinheiro', "t");
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $return = $this->db->get()->result();
        return $return[0]->valor_total;
    }

    function relatoriocaixapersonalizadonaofaturados() {

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
                            ae.valor,
                            ae.valor1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.realizada,
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
                            pt.nome as procedimento,
                            o.nome,
                            e.exames_id,
                            op.nome as nomefaturamento,
                            ae.operador_faturamento,
                            f.nome as forma_pagamento,
                            f2.nome as forma_pagamento_2,
                            f3.nome as forma_pagamento_3,
                            f4.nome as forma_pagamento_4,
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
        $this->db->where('ae.faturado', 'false');
        $this->db->where('ae.operador_autorizacao >', 0);

        if ($_POST['txtNomeid'] != '') {
            $this->db->where("ae.paciente_id", $_POST['txtNomeid']);
        }

        if ($_POST['empresa'] != '0' && $_POST['empresa'] != '') {
            $this->db->where("ae.empresa_id", $_POST['empresa']);
        }

        if ($_POST['operador'] != '0' && $_POST['operador'] != '') {
            $this->db->where("ae.operador_faturamento", $_POST['operador']);
        }
        $this->db->where('c.dinheiro', "t");
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->orderby('ae.guia_id');
        $this->db->orderby('ae.operador_faturamento');
        $this->db->orderby('ae.operador_autorizacao');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentocaixapersonalizadooperadorfaturamento($operador_faturamento) {

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
                            ae.valor,
                            ae.valor1,
                            ae.forma_pagamento as forma_pagamento1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.realizada,
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
                            pt.nome as procedimento,
                            o.nome,
                            e.exames_id,
                            op.nome as nomefaturamento,
                            ae.operador_faturamento,
                            f.nome as forma_pagamento,
                            f2.nome as forma_pagamento_2,
                            f3.nome as forma_pagamento_3,
                            f4.nome as forma_pagamento_4,
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
        $this->db->join('tb_operador_grupo_medico ogm', 'ae.medico_consulta_id = ogm.operador_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamento', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('pt.home_care', 'f');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where('c.dinheiro', "t");
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['procedimentos'] != "0") {
            $this->db->where('pt.procedimento_tuss_id', $_POST['procedimentos']);
        }
//        var_dump($_POST['grupomedico']); die;
        if ($_POST['grupomedico'] != "0") {
            $this->db->where('ogm.operador_grupo_id', $_POST['grupomedico']);
            $this->db->where('ogm.ativo', 't');
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if ($_POST['txtNome'] != '') {
            $this->db->where("p.nome ilike '%" . $_POST['txtNome'] . "%'");
        }

        if ($_POST['empresa'] != '0' && $_POST['empresa'] != '') {
            $this->db->where("ae.empresa_id", $_POST['empresa']);
        }
        if ($_POST['forma_pagamento'] == "1") {
            $this->db->where("((f.cartao = 't') OR (f2.cartao = 't') OR (f3.cartao = 't') OR (f4.cartao = 't'))");
        }
        $this->db->where("ae.operador_faturamento", $operador_faturamento);

        // SEMPRE DEIXE guia_id EM PRIMEIRO! Do contrário o relatorio de caixa personalizado não irá funcionar.
        $this->db->orderby('ae.guia_id');
        $this->db->orderby('ae.operador_faturamento');
        $this->db->orderby('ae.operador_autorizacao');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarprocedimentocaixacartaopersonalizadooperadorfaturamento($operador_faturamento) {

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
                            ae.valor,
                            ae.valor1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.realizada,
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
                            pt.nome as procedimento,
                            o.nome,
                            e.exames_id,
                            op.nome as nomefaturamento,
                            ae.operador_faturamento,
                            f.nome as forma_pagamento,
                            f2.nome as forma_pagamento_2,
                            f3.nome as forma_pagamento_3,
                            f4.nome as forma_pagamento_4,
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
        $this->db->join('tb_operador_grupo_medico ogm', 'ae.medico_consulta_id = ogm.operador_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamento', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where("((f.cartao = 't') OR (f2.cartao = 't') OR (f3.cartao = 't') OR (f4.cartao = 't'))");
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('pt.home_care', 'f');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where('c.dinheiro', "t");
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }

        if ($_POST['empresa'] != '0' && $_POST['empresa'] != '') {
            $this->db->where("ae.empresa_id", $_POST['empresa']);
        }

        $this->db->where("ae.operador_faturamento", $operador_faturamento);

        $this->db->orderby('ae.guia_id');
        $this->db->orderby('ae.operador_faturamento');
        $this->db->orderby('ae.operador_autorizacao');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixapersonalizadoprocedimentosnaofaturados() {

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
                            ae.valor,
                            ae.valor1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.realizada,
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
                            pt.nome as procedimento,
                            o.nome,
                            e.exames_id,
                            op.nome as nomefaturamento,
                            ae.operador_faturamento,
                            f.nome as forma_pagamento,
                            f2.nome as forma_pagamento_2,
                            f3.nome as forma_pagamento_3,
                            f4.nome as forma_pagamento_4,
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
        $this->db->join('tb_operador_grupo_medico ogm', 'ae.medico_consulta_id = ogm.operador_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamento', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('pt.home_care', 'f');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where('ae.operador_faturamento IS NULL');
        $this->db->where('c.dinheiro', "t");
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['forma_pagamento'] == "1") {
            $this->db->where("((f.cartao = 't') OR (f2.cartao = 't') OR (f3.cartao = 't') OR (f4.cartao = 't'))");
        }
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['procedimentos'] != "0") {
            $this->db->where('pt.procedimento_tuss_id', $_POST['procedimentos']);
        }
//        var_dump($_POST['grupomedico']); die;
        if ($_POST['grupomedico'] != "0") {
            $this->db->where('ogm.operador_grupo_id', $_POST['grupomedico']);
            $this->db->where('ogm.ativo', 't');
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }

        if ($_POST['txtNome'] != '') {
            $this->db->where("p.nome ilike '%" . $_POST['txtNome'] . "%'");
        }

        if ($_POST['empresa'] != '0' && $_POST['empresa'] != '') {
            $this->db->where("ae.empresa_id", $_POST['empresa']);
        }

        if ($_POST['operador'] != '0' && $_POST['operador'] != '') {
            $this->db->where("ae.operador_faturamento", $_POST['operador']);
        }
        $this->db->orderby('ae.guia_id');
        $this->db->orderby('ae.operador_autorizacao');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixacartaopersonalizadooperadores() {
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $sql = '';
        if ($_POST['medico'] != "0") {
            $sql .= " AND ae.medico_consulta_id = " . $_POST['medico'];
        }
        if ($_POST['empresa'] != '0' && $_POST['empresa'] != '') {
            $sql .= " AND ae.empresa_id = " . $_POST['empresa'];
        }
        if ($_POST['operador'] != '0' && $_POST['operador'] != '') {
            $sql .= " AND ae.operador_faturamento = " . $_POST['operador'];
        }

        $this->db->select('o.operador_id, o.nome');
        $this->db->from('tb_operador o');
        $this->db->where("o.operador_id IN 
                            (
                            SELECT DISTINCT(ae.operador_faturamento) FROM ponto.tb_agenda_exames ae
                            LEFT JOIN ponto.tb_paciente p ON p.paciente_id = ae.paciente_id
                            LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id
                            LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id
                            LEFT JOIN ponto.tb_operador_grupo_medico ogm ON ae.medico_consulta_id = ogm.operador_id
                            LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id
                            LEFT JOIN ponto.tb_forma_pagamento f ON f.forma_pagamento_id = ae.forma_pagamento
                            LEFT JOIN ponto.tb_forma_pagamento f2 ON f2.forma_pagamento_id = ae.forma_pagamento2
                            LEFT JOIN ponto.tb_forma_pagamento f3 ON f3.forma_pagamento_id = ae.forma_pagamento3
                            LEFT JOIN ponto.tb_forma_pagamento f4 ON f4.forma_pagamento_id = ae.forma_pagamento4
                            WHERE ae.data >= '{$data_inicio}' AND ae.data <= '{$data_fim}'
                            AND ae.confirmado = 't' AND ae.operador_autorizacao > 0
                            AND c.dinheiro = 't'
                            AND ((f.cartao = 't') OR (f2.cartao = 't') OR (f3.cartao = 't') OR (f4.cartao = 't'))
                            {$sql}
                            )");

        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
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
                            ae.forma_pagamento as forma_pagamento1,
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
                            ae.observacao,
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
        $this->db->join('tb_operador_grupo_medico ogm', 'ae.medico_consulta_id = ogm.operador_id', 'left');
//        $this->db->join('tb_operador_grupo og', 'og.operador_grupo_id = ogm.operador_grupo_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamento', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('pt.home_care', 'f');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where('pt.grupo !=', 'CIRURGICO');
        $this->db->where('c.dinheiro', "t");
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['procedimentos'] != "0") {
            $this->db->where('pt.procedimento_tuss_id', $_POST['procedimentos']);
        }
//        var_dump($_POST['grupomedico']); die;
        if ($_POST['grupomedico'] != "0") {
            $this->db->where('ogm.operador_grupo_id', $_POST['grupomedico']);
            $this->db->where('ogm.ativo', 't');
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_autorizacao', $_POST['operador']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->orderby('ae.operador_autorizacao');
//        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixamodelo2() {

        $this->db->select('ae.agenda_exames_id,
                            ae.realizada,
                            ae.data,
                            aef.data as data_faturar,
                            ae.guia_id,
                            pt.grupo,
                            c.nome as convenio,
                            ae.guia_id,
                            array_agg(f.nome) as forma_pagamento_array,
                            array_agg(aef.valor_bruto) as valor_bruto_array,
                            array_agg(aef.valor) as valor_ajustado_array,
                            array_agg(aef.ajuste) as ajuste_array,
                            array_agg(aef.desconto) as desconto_array,
                            array_agg(aef.ativo) as ativo_array,
                            array_agg(aef.financeiro) as financeiro_array,
                            array_agg(aef.parcela) as parcelas_array,

                            ae.quantidade,
                            ae.valor_total,
                            ae.paciente_id,
                            p.nome as paciente,
                            ae.procedimento_tuss_id,
                            pt.nome as procedimento,
                            o.nome as operador_autorizacao,
                            ae.operador_editar,
                            op.nome as operador_faturamento,
                            pt.codigo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_agenda_exames_faturar aef', 'aef.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = aef.forma_pagamento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador_grupo_medico ogm', 'ae.medico_consulta_id = ogm.operador_id', 'left');
//        $this->db->join('tb_operador_grupo og', 'og.operador_grupo_id = ogm.operador_grupo_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = aef.operador_cadastro', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('pt.home_care', 'f');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where('pt.grupo !=', 'CIRURGICO');
        $this->db->where('c.dinheiro', "t");
        // $this->db->where('(aef.ativo = true OR aef.ativo is null)');
        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'])));
        $data_fim = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim'])));
        $this->db->where("(aef.data >= '$data_inicio' OR (ae.data >= '$data_inicio' AND aef.data is null))");
        $this->db->where("(aef.data <= '$data_fim' OR (ae.data <= '$data_fim' AND aef.data is null))");
        // Nao testei cancelar um procedimento e ver se ele continua aparecendo aqui, então caso aconteça, esse where previne isso.
        // é só pra garantir, já que outros wheres dessa tabela já existem e anulariam isso.
        $this->db->where('ae.agenda_exames_id is not null');
//        $this->db->where("(ae.data >= '$data_inicio')");
//        $this->db->where("(ae.data <= '$data_fim')");

        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
//        if ($_POST['procedimentos'] != "0") {
//            $this->db->where('pt.procedimento_tuss_id', $_POST['procedimentos']);
//        }
//        var_dump($_POST['grupomedico']); die;
//        if ($_POST['grupomedico'] != "0") {
//            $this->db->where('ogm.operador_grupo_id', $_POST['grupomedico']);
//            $this->db->where('ogm.ativo', 't');
//        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_autorizacao', $_POST['operador']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->groupby('ae.agenda_exames_id,
                            ae.realizada,
                            ae.data,
                            aef.data,
                            ae.guia_id,
                            pt.grupo,
                            c.nome,
                            ae.guia_id,
                            pc.valortotal,
                            ae.quantidade,
                            ae.valor_total,
                            ae.paciente_id,
                            p.nome,
                            ae.procedimento_tuss_id,
                            pt.nome,
                            o.nome,
                            ae.operador_editar,
                            e.exames_id,
                            op.nome,
                            pt.codigo');
        $this->db->orderby('ae.operador_autorizacao, ae.paciente_id, p.nome, ae.agenda_exames_id');
//        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixacartaoconsolidado() {

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
        $this->db->join('tb_operador_grupo_medico ogm', 'ae.medico_consulta_id = ogm.operador_id', 'left');
//        $this->db->join('tb_operador_grupo og', 'og.operador_grupo_id = ogm.operador_grupo_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamento', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('pt.home_care', 'f');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where('c.dinheiro', "t");
        $this->db->where("(f.cartao = true OR f2.cartao = true OR f3.cartao = true OR f4.cartao = true)");
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));

        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
        }
        if ($_POST['operador'] != "0") {
            $this->db->where('ae.operador_autorizacao', $_POST['operador']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }
        $this->db->orderby('ae.operador_autorizacao');
//        $this->db->orderby('pc.convenio_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('p.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixahomecare() {

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
                            ae.forma_pagamento as forma_pagamento1,
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
        $this->db->where('pt.home_care', 't');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where("ae.data_faturamento >=", date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['txtdata_inicio'] . " 00:00:00"))));
        $this->db->where("ae.data_faturamento <=", date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['txtdata_fim'] . " 23:59:59"))));


        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
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

    function relatoriogastosala() {

        $this->db->select(' distinct(ag.ambulatorio_guia_id),
                            p.nome as paciente,
                            ag.paciente_id,
                            ag.convenio_id,
                            ags.descricao,
                            ags.valor,
                            ag.data_criacao as data,
                            
                            ags.quantidade,
                            ags.agenda_exame_id,
                            ags.data_cadastro,
                            ep.descricao as produto,
                            u.descricao as unidade,

                            pt.nome as procedimento');
        $this->db->from('tb_ambulatorio_gasto_sala ags');
        $this->db->join('tb_ambulatorio_guia ag', 'ags.guia_id = ag.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_estoque_produto ep', 'ep.estoque_produto_id = ags.produto_id', 'left');
        $this->db->join('tb_estoque_unidade u', 'u.estoque_unidade_id = ep.unidade_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = ep.procedimento_id', 'left');
//        $this->db->join('tb_procedimento_convenio pc', 'ep.procedimento_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ags.data_cadastro >=", date("Y-m-d 00:00:00", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ags.data_cadastro <=", date("Y-m-d 23:59:59", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->where("ags.ativo", 't');
//        $this->db->where("(ag.convenio_id = pc.convenio_id)");
        $this->db->where("(ep.procedimento_id = pt.procedimento_tuss_id)");
        $this->db->where("pt.ativo", 't');

        if ($_POST['txtNomeid'] != "") {
            $this->db->where('ag.paciente_id', $_POST['txtNomeid']);
        }

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
                            opp.nome as medico,
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
        $this->db->join('tb_operador opp', 'opp.operador_id = al.medico_parecer1', 'left');
        $this->db->where("((f.cartao = 't') OR (f2.cartao = 't') OR (f3.cartao = 't') OR (f4.cartao = 't'))");
//        $this->db->where('f.cartao', 't');
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
                            ae.desconto,
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

    function valoralteradohistorico($agenda_exames_id) {

        $this->db->select('ae.agenda_exames_id,
                            pt.codigo,
                            c.nome as convenio,
                            pt.nome as procedimento,
                            ae.forma_pagamento,
                            ae.forma_pagamento2,
                            ae.forma_pagamento3,
                            ae.forma_pagamento4,
                            ae.valor,
                            ae.valor2,
                            ae.valor3,
                            ae.valor4,
                            o.nome,
                            ae.valor_total,
                            ae.valor,
                            f.nome as forma,
                            f2.nome as forma2,
                            f3.nome as forma3,
                            f4.nome as forma4,
                            ');
        $this->db->from('tb_agenda_exames_valor ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_cadastro', 'left');
//        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamentoantigo', 'left');
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

    function verificavalor($guia_id) {

        $this->db->select('ambulatorio_guia_id,
                            nota_fiscal,
                            recibo,
                            valor_guia,
                            numero_nota_fiscal,
                            observacoes');
        $this->db->from('tb_ambulatorio_guia');
        $this->db->where("ambulatorio_guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function verificaobservacaorelatorio($guia_id) {

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

    function guiaconvenioexame($agenda_exames_id) {

        $this->db->select('guiaconvenio, agenda_exames_id');
        $this->db->from('tb_agenda_exames');
        $this->db->where("agenda_exames_id", $agenda_exames_id);
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
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
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

    function relatoriocaixacontadorcartaoconsolidado() {
        $this->db->select('ae.agenda_exames_id');
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
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where("(f.cartao = true OR f2.cartao = true OR f3.cartao = true OR f4.cartao = true)");
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['grupo'] == "1") {
            $this->db->where('pt.grupo !=', 'RM');
        }
        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
            $this->db->where('pt.grupo', $_POST['grupo']);
        }
        if ($_POST['medico'] != "0") {
            $this->db->where('al.medico_parecer1', $_POST['medico']);
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

        $this->db->select('o.nome as revisor, ae.valor_total, ae.valor_revisor, ae.percentual_revisor, ae.valor_medico, ae.percentual_medico,ae.quantidade');
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

//        $this->db->groupby('o.nome');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniormrevisorunico() {

        $this->db->select('distinct(o.nome) as revisor,
            ');
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

        $this->db->select('o.nome as revisor, ae.valor_total, ae.valor_revisor, ae.percentual_revisor,ae.quantidade
           ');
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

//        $this->db->groupby('o.nome, ae.percentual_revisor');
        $this->db->orderby('o.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriomedicoconveniormrevisadaunico() {

        $this->db->select('distinct(o.nome) as revisor,
           ');
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

    function gravartempomedioatendimento() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('tempo_chegada', $_POST['chegada']);
            $this->db->set('tempo_atendimento', $_POST['atendimento']);
            $this->db->set('tempo_finalizado', $_POST['finalizado']);


            $this->db->select('*');
            $this->db->from('tb_tempo_medio_atendimento');
            $return = $this->db->get()->result();
            if (count($return) > 0) {
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('data_atualizacao', $horario);
                $this->db->update('tb_tempo_medio_atendimento');
            } else {
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->insert('tb_tempo_medio_atendimento');
            }

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfiladeimpressao($html, $tipo, $paciente, $paciente_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto', $html);
            $this->db->set('nome', $tipo);
            $this->db->set('paciente', $paciente);
            $this->db->set('paciente_id', $paciente_id);


            $this->db->set('operador_solicitante', $operador_id);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->insert('tb_ambulatorio_fila_impressao');


            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function tempomedioatendimento() {


        $this->db->select('*');
        $this->db->from('tb_tempo_medio_atendimento');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamesguia($guia_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            pt.procedimento_tuss_id,
                            ae.data,
                            ae.data_entrega,
                            ae.operador_autorizacao,
                            op.nome as operador,
                            ae.inicio,
                            ae.fim,
                            ae.ativo,
                            ae.situacao,
                            ae.faturado,
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
                            ae.valor1,
                            ae.valor2,
                            ae.valor3,
                            ae.valor4,
                            ae.desconto,
                            p.sexo,
                            p.nascimento,
                            p.cpf,
                            es.nome as sala,
                            c.nome as convenio,
                            ae.autorizacao,
                            fp.nome as formadepagamento,
                            fp2.nome as formadepagamento2,
                            fp3.nome as formadepagamento3,
                            fp4.nome as formadepagamento4,
                            o.nome as medicosolicitante,
                            oz.nome as atendente,
                            pi.nome as promotor,
                            ae.indicacao as promotor2,
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
        $this->db->join('tb_paciente_indicacao pi', 'ae.indicacao = pi.paciente_indicacao_id', 'left');
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
        $this->db->join('tb_operador oz', 'oz.operador_id = ae.operador_autorizacao', 'left');
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
//        var_dump($return->result()); die;
        return $return->result();
    }

    function listarexamesguiaetiquetagrupo($guia_id) {

        $this->db->select('pt.grupo');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'ae.indicacao = pi.paciente_indicacao_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_guia ge', 'ge.ambulatorio_guia_id = ae.guia_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_empresa ep', 'ep.empresa_id = ae.empresa_id', 'left');

        $this->db->where("ae.guia_id", $guia_id);
        $this->db->where("ae.cancelada", "f");
        $this->db->groupby('pt.grupo');
        $this->db->orderby('pt.grupo');
        $return = $this->db->get();
//        var_dump($return->result()); die;
        return $return->result();
    }

    function listarexamesguialaboratorio($guia_id) {

        $this->db->select('ae.agenda_exames_id,
                            pt.procedimento_tuss_id,
                            ae.data,
                            ae.mensagem_integracao_lab,
                            ae.operador_autorizacao,
                            op.nome as operador,
                            ae.guia_id,
                            ae.paciente_id,
                            ae.data_autorizacao,
                            p.nome as paciente,
                            c.nome as convenio,
                            p.sexo,
                            p.nascimento,
                            p.cpf,
                            o.nome as medicosolicitante,
                            o.conselho as crm_solicitante,
                            ae.indicacao as promotor2,
                            pt.grupo,
                            pc.convenio_id,
                            pt.codigo,
                            ope.conselho,
                            m.estado,
                            m.codigo_ibge,
                            ag.tipo ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'ae.indicacao = pi.paciente_indicacao_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_guia ge', 'ge.ambulatorio_guia_id = ae.guia_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = e.exames_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'pt.grupo = ag.nome', 'left');
        $this->db->join('tb_empresa ep', 'ep.empresa_id = ae.empresa_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = o.municipio_id', 'left');
        $this->db->join('tb_operador ope', 'ope.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_autorizacao', 'left');
        $this->db->where("ae.guia_id", $guia_id);
        $this->db->where("pt.grupo", 'LABORATORIAL');
        // $this->db->where("ae.mensagem_integracao_lab !=", 'IMPORTADO');
        $this->db->where("ae.cancelada", "f");
        $this->db->orderby('ae.agenda_exames_id');
        $return = $this->db->get();
//        var_dump($return->result()); die;
        return $return->result();
    }

    function listarexamesrelatorioorcamento($orcamento, $data) {

        $this->db->select('oi.ambulatorio_orcamento_item_id,
                            oi.data,
                            o.nome as operador,
                            oi.valor_total,
                            oi.quantidade,
                            oi.valor,
                            oi.data_cadastro,
                            (oi.valor_ajustado * oi.quantidade) as valor_total_ajustado,
                            p.nome as paciente,
                            p.sexo,
                            p.paciente_id,
                            p.cpf,
                            p.nascimento,
                            oi.orcamento_id,
                            c.nome as convenio,
                            pc.convenio_id,
                            c.dinheiro,
                            pt.descricao_procedimento,
                            pt.codigo,
                            pt.grupo,
                            pt.nome as procedimento,
                            fp.nome as forma_pagamento');
        $this->db->from('tb_ambulatorio_orcamento_item oi');
        $this->db->join('tb_paciente p', 'p.paciente_id = oi.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = oi.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = oi.operador_cadastro', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = oi.forma_pagamento', 'left');
        $this->db->where("oi.orcamento_id", $orcamento);
        $data = date("Y-m-d", strtotime(str_replace('/', '-', $data)));
        $this->db->where("(oi.data_preferencia = '$data' OR (oi.orcamento_id = $orcamento AND oi.data_preferencia is null))");
        $this->db->where("oi.ativo", 't');
        $this->db->orderby('oi.ambulatorio_orcamento_item_id');
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
                            oi.data_cadastro,
                            p.nome as paciente,
                            p.sexo,
                            p.paciente_id,
                            p.cpf,
                            p.nascimento,
                            oi.orcamento_id,
                            oi.observacao,
                            (oi.valor_ajustado * oi.quantidade) as valor_total_ajustado,
                            c.nome as convenio,
                            pc.convenio_id,
                            c.dinheiro,
                            pt.descricao_procedimento,
                            pt.codigo,
                            pt.grupo,
                            pt.nome as procedimento,
                            fp.nome as forma_pagamento');
        $this->db->from('tb_ambulatorio_orcamento_item oi');
        $this->db->join('tb_ambulatorio_orcamento orc', 'oi.orcamento_id = orc.ambulatorio_orcamento_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = orc.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = oi.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = oi.operador_cadastro', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = oi.forma_pagamento', 'left');
        $this->db->where("oi.orcamento_id", $orcamento);
        $this->db->where("oi.ativo", 't');
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
                            c.dinheiro,
                            c.convenio_id,
                            ae.autorizacao,
                            g.valor_guia,
                            fp.nome as formadepagamento,
                            fp2.nome as formadepagamento2,
                            fp3.nome as formadepagamento3,
                            fp4.nome as formadepagamento4,
                            o.nome as medicosolicitante,
                            ae.procedimento_tuss_id,
                            oz.nome as atendente,
                            pt.grupo,
                            pt.codigo,
                            pc.convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_guia g', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador oz', 'oz.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id =ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento fp2', 'fp2.forma_pagamento_id =ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento fp3', 'fp3.forma_pagamento_id =ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento fp4', 'fp4.forma_pagamento_id =ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_autorizacao', 'left');
        $this->db->where("ae.guia_id", $guia_id);
//        $this->db->where("c.convenio_id", $convenioid);
        $this->db->where("ae.cancelada", "f");
        $this->db->orderby('ae.guia_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamesguianaoconvenio($guia_id, $convenioid) {

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
                            c.dinheiro,
                            c.convenio_id,
                            ae.autorizacao,
                            g.valor_guia,
                            fp.nome as formadepagamento,
                            fp2.nome as formadepagamento2,
                            fp3.nome as formadepagamento3,
                            fp4.nome as formadepagamento4,
                            o.nome as medicosolicitante,
                            ae.procedimento_tuss_id,
                            oz.nome as atendente,
                            pt.grupo,
                            pt.codigo,
                            pc.convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_guia g', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador oz', 'oz.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id =ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento fp2', 'fp2.forma_pagamento_id =ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento fp3', 'fp3.forma_pagamento_id =ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento fp4', 'fp4.forma_pagamento_id =ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_autorizacao', 'left');
        $this->db->where("ae.guia_id", $guia_id);
//        $this->db->where("c.convenio_id", $convenioid);
        $this->db->where("ae.cancelada", "f");
        $this->db->where("c.dinheiro", "t");
        $this->db->orderby('ae.guia_id');
        $return = $this->db->get();
        return $return->result();
    }

    function guiavalor($guia_id) {


        $this->db->select('g.valor_guia');

        $this->db->from('tb_ambulatorio_guia g');

        $this->db->where("g.ambulatorio_guia_id", $guia_id);
//        $this->db->where("c.convenio_id", $convenioid);
        $this->db->orderby('g.ambulatorio_guia_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamealterarvalor($exames_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            ae.fim,
                            ae.financeiro,
                            pc.convenio_id,
                            pc.procedimento_convenio_id,
                            ae.data_entregue,
                            ae.medico_consulta_id,
                            (ae.valor * ae.quantidade) as valor,
                            ae.valor_total,
                            ae.ativo,
                            ae.situacao
                           ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->where("ae.agenda_exames_id", $exames_id);
        // $this->db->where("ae.cancelada", "f");
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
                            ae.data_entregue,
                            (ae.valor * ae.quantidade) as valor,
                            ae.valor_total,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.situacao_faturamento,
                            ae.tipo,
                            ae.financeiro,
                            ae.data_atualizacao,
                            ae.data_realizacao,
                            ae.paciente_id,
                            ae.data_entrega,
                            p.nome as paciente,
                            p.sexo,
                            p.paciente_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            c.dinheiro,
                            ae.autorizacao,
                            ae.valor1,
                            ae.valor2,
                            ae.valor3,
                            ae.valor4,
                            ae.forma_pagamento,
                            ae.forma_pagamento2,
                            ae.forma_pagamento3,
                            ae.forma_pagamento4,
                            ae.forma_pagamento_ajuste,
                            ae.desconto,
                            ae.data_autorizacao,
                            ae.agrupador_fisioterapia,
                            ae.numero_sessao,
                            ae.observacoes,
                            ae.qtde_sessao,
                            ae.texto,
                            o.nome as medicosolicitante,
                            o.conselho as crm_solicitante,
                            op.nome as atendente,
                            op.usuario,
                            opm.nome as medico,
                            opm.conselho as crm_medico,
                            opf.nome as atendente_fatura,
                            ex.exames_id,
                            fp.nome as formadepagamento,
                            ae.procedimento_tuss_id,
                            pt.grupo,
                            pt.codigo,
                            ep.logradouro,
                            ep.razao_social,
                            ep.cnpj,
                            ep.numero,
                            ep.telefone as telefoneempresa,
                            ep.celular as celularempresa,
                            ep.bairro,
                            ep.email,
                            ep.razao_social,
                            es.nome as sala,
                            ae.cid,
                            p.logradouro as logradouro_paciente,
                            p.numero as numero_paciente,
                            p.complemento as complemento_paciente,
                            p.bairro as bairro_paciente,
                            p.raca_cor,
                            p.rg,
                            piae.nome as promotor,
                            cid.no_cid,
                            c.convenio_id,
                            c.nome as convenio,
                            ag.data_cadastro as data_guia,
                            ae.guiaconvenio,
                            ag.ambulatorio_guia_id,
                            p.nascimento,
                            p.celular,
                            p.telefone,
                            c.dinheiro,
                            ae.diabetes,
                            ae.hipertensao,
                            ae.medico_solicitante,
                            ae.agenda_exames_nome_id,
                            ae.medico_agenda,
                            ae.procedimento_possui_ajuste_pagamento,
                            ae.valor_forma_pagamento_ajuste as valor_ajuste,
                            ae.faturado,
                            cbo.descricao as profissaos,
                            pt.perc_medico,
                            m.nome as municipio,
                            m.estado,
                            l.data_atualizacao as data_finalizado,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao', 'left');
        $this->db->join('tb_paciente_indicacao piae', 'piae.paciente_indicacao_id = ae.indicacao', 'left');
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames ex', 'ex.agenda_exames_id =ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = ex.exames_id', 'left');
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
        // $this->db->where("ae.cancelada", "f");
        $return = $this->db->get();
        return $return->result();
    }
    
    function listarexamegrupos($guia_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            pi.nome as indicacao,
                            es.nome as agenda,
                            ae.fim,
                            ae.data_entregue,
                            (ae.valor * ae.quantidade) as valor,
                            ae.valor_total,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.situacao_faturamento,
                            ae.tipo,
                            ae.financeiro,
                            ae.data_atualizacao,
                            ae.data_realizacao,
                            ae.paciente_id,
                            ae.data_entrega,
                            p.nome as paciente,
                            p.sexo,
                            p.paciente_id,
                            pc.convenio_id,
                            c.nome as convenio,
                            c.dinheiro,
                            ae.autorizacao,
                            ae.valor1,
                            ae.valor2,
                            ae.valor3,
                            ae.valor4,
                            ae.forma_pagamento,
                            ae.forma_pagamento2,
                            ae.forma_pagamento3,
                            ae.forma_pagamento4,
                            ae.forma_pagamento_ajuste,
                            ae.desconto,
                            ae.data_autorizacao,
                            ae.agrupador_fisioterapia,
                            ae.numero_sessao,
                            ae.observacoes,
                            ae.qtde_sessao,
                            ae.texto,
                            o.nome as medicosolicitante,
                            o.conselho as crm_solicitante,
                            op.nome as atendente,
                            op.usuario,
                            opm.nome as medico,
                            opm.conselho as crm_medico,
                            opf.nome as atendente_fatura,
                            ex.exames_id,
                            fp.nome as formadepagamento,
                            ae.procedimento_tuss_id,
                            pt.grupo,
                            pt.codigo,
                            ep.logradouro,
                            ep.razao_social,
                            ep.cnpj,
                            ep.numero,
                            ep.telefone as telefoneempresa,
                            ep.celular as celularempresa,
                            ep.bairro,
                            ep.email,
                            ep.razao_social,
                            es.nome as sala,
                            ae.cid,
                            p.logradouro as logradouro_paciente,
                            p.numero as numero_paciente,
                            p.complemento as complemento_paciente,
                            p.bairro as bairro_paciente,
                            p.raca_cor,
                            p.rg,
                            piae.nome as promotor,
                            cid.no_cid,
                            c.convenio_id,
                            c.nome as convenio,
                            ag.data_cadastro as data_guia,
                            ae.guiaconvenio,
                            ag.ambulatorio_guia_id,
                            p.nascimento,
                            p.celular,
                            p.telefone,
                            c.dinheiro,
                            ae.diabetes,
                            ae.hipertensao,
                            ae.medico_solicitante,
                            ae.agenda_exames_nome_id,
                            ae.medico_agenda,
                            ae.procedimento_possui_ajuste_pagamento,
                            ae.valor_forma_pagamento_ajuste as valor_ajuste,
                            ae.faturado,
                            cbo.descricao as profissaos,
                            pt.perc_medico,
                            m.nome as municipio,
                            m.estado,
                            l.data_atualizacao as data_finalizado,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao', 'left');
        $this->db->join('tb_paciente_indicacao piae', 'piae.paciente_indicacao_id = ae.indicacao', 'left');
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames ex', 'ex.agenda_exames_id =ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = ex.exames_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id =ae.forma_pagamento', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador opm', 'opm.operador_id = ae.medico_agenda', 'left');
        $this->db->join('tb_operador opf', 'opf.operador_id = ae.operador_faturamento', 'left');
        $this->db->join('tb_empresa ep', 'ep.empresa_id = ae.empresa_id', 'left');
        $this->db->join('tb_ambulatorio_guia ag', 'ag.ambulatorio_guia_id = ae.guia_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = ep.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = ae.cid', 'left');
        $this->db->where("ae.guia_id", $guia_id);
        
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameanterior($paciente_id, $data_exame = null) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data
                            ');
        $this->db->from('tb_agenda_exames ae');

        $this->db->where("ae.paciente_id", $paciente_id);
        $this->db->where("ae.data <", $data_exame);
        $this->db->where("ae.cancelada", "f");
        $this->db->where("ae.realizada", "t");
        $this->db->where("ae.confirmado", "t");
        $return = $this->db->get();
        return $return->result();
    }

    function listarexamerecibo($exames_id) {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.inicio,
                            pi.nome as indicacao,
                            es.nome as agenda,
                            ae.fim,
                            ae.data_entregue,
                            (ae.valor * ae.quantidade) as valor,
                            ae.valor_total,
                            ae.ativo,
                            ae.situacao,
                            ae.guia_id,
                            ae.situacao_faturamento,
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
                            c.dinheiro,
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
                            pt.codigo,
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
                            p.rg,
                            piae.nome as promotor,
                            cid.no_cid,
                            c.convenio_id,
                            c.nome as convenio,
                            ag.data_cadastro as data_guia,
                            ae.guiaconvenio,
                            ag.ambulatorio_guia_id,
                            p.nascimento,
                            p.celular,
                            p.telefone,
                            c.dinheiro,
                            ae.diabetes,
                            ae.hipertensao,
                            ae.medico_solicitante,
                            ae.agenda_exames_nome_id,
                            ae.medico_agenda,
                            cbo.descricao as profissaos,
                            pt.perc_medico,
                            m.nome as municipio,
                            m.estado,
                            l.data_atualizacao as data_finalizado,
                            pt.codigo,
                            pt.nome as procedimento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao', 'left');
        $this->db->join('tb_paciente_indicacao piae', 'piae.paciente_indicacao_id = ae.indicacao', 'left');
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames ex', 'ex.agenda_exames_id =ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo l', 'l.exame_id = ex.exames_id', 'left');
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
//        $this->db->where("c.dinheiro", "t");
        $this->db->orderby("ae.agenda_exames_id");
        $return = $this->db->get();
        return $return->result();
    }

    function listargrupoficha($guia_id, $grupo) {

        $this->db->select('distinct(pt.grupo), c.nome as convenio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');

        $this->db->where("pt.grupo", $grupo);
        $this->db->where("ae.guia_id", $guia_id);
        $this->db->where("ae.cancelada", "f");
        $this->db->groupby("pt.grupo, c.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguia($guia_id) {

        $this->db->select('sum((valor * quantidade)) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
//        $this->db->where('faturado', 'f');
        $this->db->where('confirmado', 't');
        $this->db->where('c.dinheiro', 't');
        $this->db->where("guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguiafaturarconvenio($guia_id) {

        $this->db->select('sum((valor * quantidade)) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
//        $this->db->where('faturado', 'f');
        $this->db->where('confirmado', 't');
//        $this->db->where('c.dinheiro', 't');
        $this->db->where("guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguiaprocedimentosmodelo2($guia_id) {

        $this->db->select('sum((valor * quantidade)) as valor_total, 
                           array_agg(ae.agenda_exames_id) as array_exames,
                           array_agg(valor * quantidade) as array_valores,
                           paciente_id
    
                        ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        // $this->db->where('faturado', 'f');
        $this->db->where('confirmado', 't');
        $this->db->where('c.dinheiro', 't');
        $this->db->where("guia_id", $guia_id);
        $this->db->groupby("guia_id, paciente_id");
        $return = $this->db->get();
        return $return->result();
    }

    function listardescontoTotal($agenda_exames_id) {

        $this->db->select('sum(aef.desconto) as desconto');
                        
        $this->db->from('tb_agenda_exames_faturar aef');
        $this->db->where("aef.ativo", 't');
        $this->db->where("aef.agenda_exames_id", $agenda_exames_id);
        $this->db->groupby("aef.agenda_exames_id");
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguiaprocedimentos($guia_id) {

        $this->db->select('sum((valor * quantidade)) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('faturado', 'f');
        $this->db->where('confirmado', 't');
        $this->db->where('c.dinheiro', 't');
        $this->db->where("guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguiaprocedimentospersonalizado($guia_id) {

        $this->db->select('valor, quantidade, 
                           forma_pagamento_ajuste,
                           valor_forma_pagamento_ajuste as valor_ajuste,
                           procedimento_possui_ajuste_pagamento');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('faturado', 'f');
        $this->db->where('confirmado', 't');
        $this->db->where('c.dinheiro', 't');
        $this->db->where("guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguiaforma($guia_id, $financeiro_grupo_id) {
        $this->db->select('sum((valor * quantidade)) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio_pagamento cp', 'cp.procedimento_convenio_id = ae.procedimento_tuss_id');
        $this->db->where("guia_id", $guia_id);
        $this->db->where("cp.ativo", 't');
        if ($financeiro_grupo_id != null) {
            $this->db->where("cp.grupo_pagamento_id", $financeiro_grupo_id);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguiaformaprocedimentos($guia_id, $financeiro_grupo_id) {
        $this->db->select('sum((valor * quantidade)) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio_pagamento cp', 'cp.procedimento_convenio_id = ae.procedimento_tuss_id');
        $this->db->where("guia_id", $guia_id);
        $this->db->where("ae.faturado", 'f');
        $this->db->where("ae.confirmado", 't');
        $this->db->where("cp.ativo", 't');
        if ($financeiro_grupo_id != null) {
            $this->db->where("cp.grupo_pagamento_id", $financeiro_grupo_id);
        }
        $return = $this->db->get();

        return $return->result();
    }

    function listarobservacao($guia_id) {
        $this->db->select('ae.observacao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where("guia_id", $guia_id);

        $return = $this->db->get();

        return $return->result();
    }

    function listaenviartodosfiladecaixa($guia_id) {
        $this->db->select('agenda_exames_id, procedimento_tuss_id, paciente_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where("guia_id", $guia_id);
        $this->db->where("ae.realizada", 'f');
        $this->db->where("ae.confirmado", 't');
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
        $credito = $this->creditoempresa();
//        var_dump($credito); die;
        $this->db->select('forma_pagamento_id,
                            nome,
                            parcela_minima');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 't');
        if ($credito == 'f') {
            $this->db->where('forma_pagamento_id !=', 1000);
        }
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function formadepagamentofaturarcredito() {

        $this->db->select('forma_pagamento_id,
                            nome,
                            parcela_minima');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 't');
        $this->db->where('forma_pagamento_id !=', 1000);
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function formadepagamentoguianovo() {
        $this->db->select('forma_pagamento_id,
                            nome,
                            parcela_minima');
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 't');
        $this->db->where('forma_pagamento_id !=', 1000);
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function formadepagamentoprocedimento($procedimento_convenio_id) {
        $credito = $this->creditoempresa();
//        var_dum
        $this->db->select('fp.forma_pagamento_id,
                            fp.nome as nome');
        $this->db->from('tb_procedimento_convenio_pagamento pp');
        $this->db->join('tb_grupo_formapagamento gf', 'gf.grupo_id = pp.grupo_pagamento_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('procedimento_convenio_id', $procedimento_convenio_id);
        $this->db->where('gf.ativo', 't');
        $this->db->where('fp.ativo', 't');
        $this->db->where('pp.ativo', 't');
        if ($credito == 'f') {
            $this->db->where('fp.forma_pagamento_id !=', 1000);
        }
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        $retorno = $return->result();

        if (empty($retorno)) {
            $this->db->select('fp.forma_pagamento_id,
                            fp.nome as nome');
            $this->db->from('tb_forma_pagamento fp');
            $this->db->where('ativo', 't');
            if ($credito == 'f') {
                $this->db->where('fp.forma_pagamento_id !=', 1000);
            }
            $this->db->orderby('fp.nome');
            $return = $this->db->get();
            return $return->result();
        } else {
            return $retorno;
        }
    }

    function agendaExamesFormasPagamentoFinanceiro($agenda_exames_id) {

//        var_dum
        // Dentro do select tem um pequeno select interno que faz a contagem pra saber quanto ainda resta a pagar
        // Desse procedimento
        $this->db->select('
                            aef.agenda_exames_id,
                            array_agg(aef.financeiro) as array_financeiro', false);
        $this->db->from('tb_agenda_exames_faturar aef');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = aef.forma_pagamento_id', 'left');
        $this->db->where('aef.agenda_exames_id', $agenda_exames_id);
        $this->db->where('aef.ativo', 't');
        $this->db->groupby('aef.agenda_exames_id');
        $return = $this->db->get();
        $retorno = $return->result();
        return $retorno;
    }

    function agendaExamesFormasPagamento($agenda_exames_id) {

//        var_dum
        // Dentro do select tem um pequeno select interno que faz a contagem pra saber quanto ainda resta a pagar
        // Desse procedimento
        $this->db->select('fp.forma_pagamento_id,
                            aef.agenda_exames_faturar_id,
                            aef.agenda_exames_id,
                            aef.valor_total,
                            (aef.valor_total - (select sum(valor_bruto) + sum(desconto)  as valorTotPag from ponto.tb_agenda_exames_faturar aef2
                            where aef2.agenda_exames_id = aef.agenda_exames_id and ativo = true)) as valor_restante,
                            aef.valor,
                            aef.valor_bruto,
                            aef.data,
                            aef.ajuste,
                            aef.parcela,
                            aef.financeiro,
                            aef.desconto,
                            aef.agenda_exames_faturar_id,
                            fp.nome as forma_pagamento', false);
        $this->db->from('tb_agenda_exames_faturar aef');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = aef.forma_pagamento_id', 'left');
        $this->db->where('aef.agenda_exames_id', $agenda_exames_id);
        $this->db->where('aef.ativo', 't');
        $this->db->orderby('aef.data, fp.nome');
        $return = $this->db->get();
        $retorno = $return->result();
        return $retorno;
    }

    function agendaExamesFormasPagamentoGuia($guia_id) {

//        var_dum
        // Dentro do select tem um pequeno select interno que faz a contagem pra saber quanto ainda resta a pagar
        // Desse procedimento
        $this->db->select('fp.forma_pagamento_id,
                            aef.guia_id,
                            sum(aef.valor_total) as valor_total,
                            (sum(aef.valor_total) - (select sum(valor_bruto) + sum(desconto)  as valorTotPag from ponto.tb_agenda_exames_faturar aef2
                            where aef2.guia_id = aef.guia_id and ativo = true)) as valor_restante,
                            sum(aef.valor) as valor,
                            sum(aef.valor_bruto) as valor_bruto,
                            array_agg(aef.financeiro) as array_financeiro,
                            aef.data,
                            aef.ajuste,
                            aef.parcela,
                            sum(aef.desconto) as desconto,
                            
                            fp.nome as forma_pagamento', false);
        $this->db->from('tb_agenda_exames_faturar aef');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = aef.forma_pagamento_id', 'left');
        $this->db->where('aef.guia_id', $guia_id);
        $this->db->where('aef.ativo', 't');
        $this->db->groupby('fp.forma_pagamento_id,
                            aef.guia_id,
                            aef.data,
                            aef.ajuste,
                            aef.parcela,
                            fp.nome
                            ');
        $this->db->orderby('aef.data, fp.nome');
        $return = $this->db->get();
        $retorno = $return->result();
        return $retorno;
    }

    function agendaExamesFormasPagamentoGuiaTotal($guia_id) {

//        var_dum
        // Dentro do select tem um pequeno select interno que faz a contagem pra saber quanto ainda resta a pagar
        // Desse procedimento
        $this->db->select('
                            aef.guia_id,
                            sum(aef.valor_total) as valor_total,
                            (sum(aef.valor_total) - (select sum(valor_bruto) + sum(desconto)  as valorTotPag from ponto.tb_agenda_exames_faturar aef2
                            where aef2.guia_id = aef.guia_id and ativo = true)) as valor_restante,
                            sum(aef.valor) as valor,
                            sum(valor_bruto) + sum(desconto) as valor_total_pago,
                            
                            sum(aef.desconto) as desconto', false);
        $this->db->from('tb_agenda_exames_faturar aef');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = aef.forma_pagamento_id', 'left');
        $this->db->where('aef.guia_id', $guia_id);
        $this->db->where('aef.ativo', 't');
        $this->db->groupby('
                            aef.guia_id,
                            
                            ');
        // $this->db->orderby('');
        $return = $this->db->get();
        $retorno = $return->result();
        return $retorno;
    }

    function agendaExamesFormasPagamentoGuiaTotalLab($guia_id) {

//        var_dum
        // Dentro do select tem um pequeno select interno que faz a contagem pra saber quanto ainda resta a pagar
        // Desse procedimento
        $this->db->select('
                            aef.guia_id,
                            sum(aef.valor_total) as valor_total,
                            array_agg(aef.valor_total),
                            (sum(aef.valor_total) - (select sum(valor_bruto) + sum(desconto)  as valorTotPag from ponto.tb_agenda_exames_faturar aef2
                            where aef2.guia_id = aef.guia_id and ativo = true)) as valor_restante,
                            sum(aef.valor) as valor,
                            sum(valor_bruto) + sum(desconto) as valor_total_pago,
                            
                            sum(aef.desconto) as desconto', false);
        $this->db->from('tb_agenda_exames_faturar aef');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = aef.forma_pagamento_id', 'left');
        $this->db->where('aef.guia_id', $guia_id);
        $this->db->where('aef.ativo', 't');
        $this->db->groupby('
                            aef.guia_id,
                            
                            ');
        // $this->db->orderby('');
        $return = $this->db->get();
        $retorno = $return->result();
        return $retorno;
    }

    function formadepagamentoguia($guia_id, $financeiro_grupo_id) {

        $this->db->select('distinct(fp.nome),
                           fp.forma_pagamento_id,
                           fp.parcela_minima');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_grupo_formapagamento gf', 'gf.grupo_id = pp.grupo_pagamento_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('ae.guia_id', $guia_id);
        $this->db->where('pp.ativo', 't');
        $this->db->where('gf.grupo_id', $financeiro_grupo_id);
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function formadepagamentoguiaprocedimentos($guia_id, $financeiro_grupo_id) {
        $credito = $this->creditoempresa();

        $this->db->select('distinct(fp.nome),
                           fp.forma_pagamento_id,
                           fp.parcela_minima');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_grupo_formapagamento gf', 'gf.grupo_id = pp.grupo_pagamento_id', 'left');
        $this->db->join('tb_forma_pagamento fp', 'fp.forma_pagamento_id = gf.forma_pagamento_id', 'left');
        $this->db->where('ae.guia_id', $guia_id);
        $this->db->where('pp.ativo', 't');
        $this->db->where('gf.grupo_id', $financeiro_grupo_id);
        if ($credito == 'f') {
            $this->db->where('fp.forma_pagamento_id !=', 1000);
        }
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

    function listarmedicosranqueados($parametro = null) {
        $this->db->select("operador_id,
                            nome,
                            conselho,
                            (
                            SELECT COUNT(agenda_exames_id) FROM ponto.tb_agenda_exames ae
                            WHERE o.operador_id = ae.medico_solicitante
                            LIMIT 1000
                            ) AS rank");
        $this->db->from('tb_operador o');
        $this->db->where('ativo', 't');
        $this->db->where('medico', 'true');
        if ($parametro != null) {
            $this->db->where("(nome ilike '%$parametro%' OR conselho ilike '%$parametro%')");
        }
        $this->db->orderby("rank DESC, nome");

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

    function listarorcamentorecepcao() {
        if ($_POST['txtNomeid'] == '') {
            if ($_POST['nascimento'] != '') {
                $this->db->set('nascimento', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['nascimento']))));
            }
            if ($_POST['cpf'] != '') {
                $this->db->set('cpf', str_replace(".", "",str_replace("-", "",$_POST['cpf'])));
            }
            $this->db->set('celular', $_POST['txtCelular']);
            $this->db->set('telefone', $_POST['txtTelefone']);
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('cns', $_POST['email']);
            $this->db->insert('tb_paciente');
            $paciente_id = $this->db->insert_id();
        } else {
            $paciente_id = $_POST['txtNomeid'];

            if ($_POST['cpf'] != '') {
                $this->db->set('cpf', str_replace(".", "",str_replace("-", "",$_POST['cpf'])));
            }
            $this->db->set('celular', $_POST['txtCelular']);
            $this->db->set('telefone', $_POST['txtTelefone']);
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('cns', $_POST['email']);
            $this->db->where('paciente_id', $paciente_id);
            $this->db->update('tb_paciente');
        }

        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ambulatorio_orcamento_id');
        $this->db->from('tb_ambulatorio_orcamento');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('paciente_id', $paciente_id);
        $this->db->where('data_criacao', $data);
        $return = $this->db->get();

        $retorno = array(
            "orcamento" => $return->row_array(),
            "paciente_id" => $paciente_id
        );

        return $retorno;
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
        $empresa_id = $_POST['empresa_id'];

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
                AND empresa_id >= $empresa_id 
                AND data >= '$data_inicio' 
                AND data <= '$data_fim'";
        $this->db->query($sql);
        return 0;
    }

    function consultargeralparticular($mes, $ano) {

        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = $ano
   and c.dinheiro = true
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralparticularfaturado($mes, $ano) {

        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = $ano
   and c.dinheiro = true
   and ae.faturado = true
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralparticularnaofaturado($mes, $ano) {

        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = $ano
   and c.dinheiro = true
   and ae.faturado = false
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralconveniofaturado($mes, $ano) {
        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = $ano
   and c.dinheiro = false
   and ae.faturado = true
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralconvenionaofaturado($mes, $ano) {
        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = $ano
   and c.dinheiro = false
   and ae.faturado = false
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralconvenio($mes, $ano) {
        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = $ano
   and c.dinheiro = false
   and e.cancelada = false
   and e.situacao = 'FINALIZADO'";
        $return = $this->db->query($sql)->result();
        return $return;
    }

    function consultargeralsintetico($mes, $ano) {
        $sql = "SELECT sum (valor_total) as total
   FROM ponto.tb_agenda_exames ae
   left join ponto.tb_exames as e on e.agenda_exames_id = ae.agenda_exames_id
   left join ponto.tb_procedimento_convenio as pc on pc.procedimento_convenio_id = ae.procedimento_tuss_id
   left join ponto.tb_procedimento_tuss as pt on pt.procedimento_tuss_id = pc.procedimento_tuss_id
   left join ponto.tb_convenio as c on c.convenio_id = pc.convenio_id
   WHERE EXTRACT('Month' From data) = $mes
   and Extract (Year from data) = $ano
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

    function excluirsolicitacaoprocedimentosadt($solicitacao_procedimento_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
//            $empresa_id = $this->session->userdata('empresa_id');
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('solicitacao_sadt_procedimento_id', $solicitacao_procedimento_id);
            $this->db->update('tb_solicitacao_sadt_procedimento');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
//                $ambulatorio_guia_id = $this->db->insert_id();
                return $ambulatorio_guia_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarnovasolicitacaosadt($paciente_id, $convenio_id, $solicitante_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $empresa_id = $this->session->userdata('empresa_id');
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('medico_solicitante', $solicitante_id);
            $this->db->set('convenio_id', $convenio_id);
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->insert('tb_solicitacao_sadt');

            $insert_id = $this->db->insert_id();
            return $insert_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarprocedimentosolicitacaosadt($solicitacao_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $empresa_id = $this->session->userdata('empresa_id');
            $operador_id = $this->session->userdata('operador_id');
//            $this->db->set('medico_solicitante', $_POST['solicitante']);
            $this->db->set('procedimento_convenio_id', $_POST['procedimento1']);
            $this->db->set('quantidade', $_POST['quantidade']);
            $this->db->set('valor', $_POST['valor1']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('solicitacao_sadt_id', $solicitacao_id);
            $this->db->insert('tb_solicitacao_sadt_procedimento');
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

    function gravarchecknota($ambulatorio_guia_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('checado', 't');
            $this->db->set('data_checado', $horario);
            $this->db->set('operador_checado', $operador_id);
            $this->db->where('ambulatorio_guia_id', $ambulatorio_guia_id);
            $this->db->update('tb_ambulatorio_guia');

            return $ambulatorio_guia_id;
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

        $this->db->set('data_observacoes', $horario);
        $this->db->set('operador_observacoes', $operador_id);
        $this->db->where('ambulatorio_guia_id', $guia_id);
        $this->db->update('tb_ambulatorio_guia');
    }

    function gravarvalorguia($guia_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('nota_fiscal', $_POST['nota_fiscal']);
        $this->db->set('numero_nota_fiscal', $_POST['numero_nota_fiscal']);
        if ($_POST['txtvalorguia'] != '') {

            $this->db->set('valor_guia', str_replace(",", ".", str_replace(",", ".", str_replace(".", "", $_POST['txtvalorguia']))));
        }

        $this->db->set('recibo', $_POST['recibo']);
        $this->db->set('data_observacoes', $horario);
        $this->db->set('operador_observacoes', $operador_id);
        $this->db->where('ambulatorio_guia_id', $guia_id);
        $this->db->update('tb_ambulatorio_guia');
    }

    function gravarnotavalor($guia_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
//        $this->db->set('observacoes', $_POST['observacoes']);
        $this->db->set('nota_fiscal', 't');
        if ($_POST['txtvalorguia'] != '') {
            $this->db->set('valor_guia', str_replace(",", ".", $_POST['txtvalorguia']));
        }
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('checado', 't');
        $this->db->set('data_checado', $horario);
        $this->db->set('operador_checado', $operador_id);
        $this->db->where('ambulatorio_guia_id', $guia_id);
        $this->db->update('tb_ambulatorio_guia');
    }

    function gravarguiajsonlaboratorio($guia_id, $json, $mensagem_imp) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
//        $this->db->set('observacoes', $_POST['observacoes']);
        $this->db->set('mensagem_integracao_lab', $mensagem_imp);
        $this->db->set('json_integracao_lab', $json);
        $this->db->set('data_integracao_lab', $horario);
        $this->db->set('operador_integracao_lab', $operador_id);
        $this->db->where('guia_id', $guia_id);
        $this->db->update('tb_agenda_exames');
    }

    function gravarguiajsonlaboratorioresultado($guia_id, $json, $mensagem_imp) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
//        $this->db->set('observacoes', $_POST['observacoes']);
        $this->db->set('mensagem_integracao_lab', $mensagem_imp);
        $this->db->set('json_resultado_lab', $json);
        $this->db->set('data_resultado_lab', $horario);
        $this->db->set('operador_resultado_lab', $operador_id);
        $this->db->where('guia_id', $guia_id);
        $this->db->update('tb_agenda_exames');
    }

    function gravarguiaconvenio($guia_id) {
        $this->db->set('guiaconvenio', $_POST['guiaconvenio']);
        $this->db->where('guia_id', $guia_id);
        $this->db->update('tb_agenda_exames');
    }

    function gravarguiaconvenioexame($agenda_exames_id) {
        $this->db->set('guiaconvenio', $_POST['guiaconvenio']);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
    }

    function gravarfaturadopersonalizado() {
        try {
            $desconto = $_POST['desconto'];
            $valor1 = $_POST['valor1'];
            $valor2 = $_POST['valor2'];
            $valor3 = $_POST['valor3'];
            $valor4 = $_POST['valor4'];

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if ($_POST['formapamento1'] != '') {
                $this->db->set('forma_pagamento', $_POST['formapamento1']);
                $this->db->set('valor1', (float) str_replace(",", ".", $valor1));
                $this->db->set('parcelas1', 1);
                $this->db->set('desconto_ajuste1', 0);
            }
            if ($_POST['formapamento2'] != '') {
                $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                $this->db->set('valor2', (float) str_replace(",", ".", $valor2));
                $this->db->set('parcelas2', 1);
                $this->db->set('desconto_ajuste2', 0);
            }
            if ($_POST['formapamento3'] != '') {
                $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                $this->db->set('valor3', (float) str_replace(",", ".", $valor3));
                $this->db->set('parcelas3', 1);
                $this->db->set('desconto_ajuste3', 0);
            }
            if ($_POST['formapamento4'] != '') {
                $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                $this->db->set('valor4', (float) str_replace(",", ".", $valor4));
                $this->db->set('parcelas4', 1);
                $this->db->set('desconto_ajuste4', 0);
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

    function verificarPagamentoExistente($agenda_exames_id, $forma_pagamento_id, $data = null) {

        if ($data == null) {
            $data = date("Y-m-d");
        }

        $this->db->select('*');
        $this->db->from('tb_agenda_exames_faturar');
        $this->db->where('data', $data);
        $this->db->where('forma_pagamento_id', $forma_pagamento_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        $result = $return->result();

        return $result;
    }

    function gravarProcedimentosBackupFaturar($forma_pagamento_id, $guia_id, $alteracao = 'EDITAR') {

        $this->db->select('*');
        $this->db->from('tb_agenda_exames_faturar');
        $this->db->where('guia_id', $guia_id);
        $this->db->where('forma_pagamento_id', $forma_pagamento_id);
        $return = $this->db->get();
        $result = $return->result();

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        foreach ($result as $item) {

            $this->db->set('agenda_exames_faturar_id', $item->agenda_exames_faturar_id);
            $this->db->set('json_salvar', json_encode($item));
            $this->db->set('alteracao', $alteracao);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_agenda_exames_faturar_bkp');
        }
    }

    function gravarProcedimentosAgendaExamesBackupFaturar($agenda_exames_id, $alteracao = 'EDITAR') {

        $this->db->select('*');
        $this->db->from('tb_agenda_exames_faturar');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get();
        $result = $return->result();

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        foreach ($result as $item) {

            $this->db->set('agenda_exames_faturar_id', $item->agenda_exames_faturar_id);
            $this->db->set('json_salvar', json_encode($item));
            $this->db->set('alteracao', $alteracao);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_agenda_exames_faturar_bkp');
        }
    }

    function gravarBackupFaturar($agenda_exames_faturar_id, $alteracao = 'EDITAR') {

        $this->db->select('*');
        $this->db->from('tb_agenda_exames_faturar');
        $this->db->where('agenda_exames_faturar_id', $agenda_exames_faturar_id);
        $return = $this->db->get();
        $result = $return->result();
        // echo '<pre>';
        // var_dump($result);
        // die;
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('agenda_exames_faturar_id', $agenda_exames_faturar_id);
        $this->db->set('json_salvar', json_encode($result));
        $this->db->set('alteracao', $alteracao);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_agenda_exames_faturar_bkp');
    }

    function apagarfaturarmodelo2($agenda_exames_faturar_id) {
        try {

            // Gravando backup das alterações 
            $this->gravarBackupFaturar($agenda_exames_faturar_id, 'EXCLUIR');

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('agenda_exames_faturar_id', $agenda_exames_faturar_id);
            $this->db->update('tb_agenda_exames_faturar');

            // echo 'something'; die;
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function apagarfaturarprocedimentosmodelo2($forma_pagamento_id, $guia_id, $data_pag) {
        try {

            // Gravando backup das alterações 
            $this->gravarProcedimentosBackupFaturar($forma_pagamento_id, $guia_id, 'EXCLUIR GUIA', $data_pag);

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('guia_id', $guia_id);
            $this->db->where('forma_pagamento_id', $forma_pagamento_id);
            $this->db->where('data', $data_pag);
            $this->db->update('tb_agenda_exames_faturar');

            // echo 'something'; die;
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function apagarfaturartrocarprocmodelo2($agenda_exames_id) {
        try {

            // Gravando backup das alterações 
            $this->gravarProcedimentosAgendaExamesBackupFaturar($agenda_exames_id, 'EDITAR PROCEDIMENTO');

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->delete('tb_agenda_exames_faturar');
            // AQUI TEM QUE DELETAR MESMO, MAS NAO SE PREOCUPE, ELE SALVA O BACKUP
            // TO USANDO CAPSLOCK PORQUE TRAVOU MEU TECLADO E NAO QUERO REINICIAR O PC. 
            // 
            // echo 'something'; die;
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentomodelo2() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // echo '<pre>';
            // var_dump($_POST); die;
            $desconto = (float) $_POST['desconto'];
            $valor1 = (float) $_POST['valor1'];
            $ajuste1 = (float) $_POST['ajuste1'];
            $valor_bruto = (float) $_POST['valor1'];
            $valorajuste1 = (float) $_POST['valorajuste1'];
            $valor_proc = (float) $_POST['valor_proc'];
            $parcela1 = (int) $_POST['parcela1'];
            $guia_id = $_POST['guia_id'];
            $agenda_exames_id = $_POST['agenda_exames_id'];
            $procedimento_convenio_id = $_POST['procedimento_convenio_id'];
            $forma_pagamento_id = $_POST['forma_pagamento_id'];
            $data = date("Y-m-d");

            // Verifica se tem uma forma já cadastrada para adicionar o valor a ela, ao invés de inserir uma nova linha
            // Isso no caso de já haver uma forma de pagamento para aquele dia naquele exame
            // $verificarExi = $this->verificarPagamentoExistente($agenda_exames_id, $forma_pagamento_id, $data);
            // Mas deixei a lógica de lado por enquanto, não quero complicar a vida tão cedo.
            // Apesar de já ser complicada
            // if(count($verificarExi) > 0){
            //     $valor1New = $verificarExi[0]->valor + $valor1;
            //     $valor_brutoNew = $verificarExi[0]->valor + $valor_bruto;
            //     $valorNew = $verificarExi[0]->valor + $valor1;
            //     $valorNew = $verificarExi[0]->valor + $valor1;
            // }else{
            $this->db->set('forma_pagamento_id', $forma_pagamento_id);
            $this->db->set('parcela', $parcela1);
            $this->db->set('guia_id', $guia_id);
            $this->db->set('agenda_exames_id', $agenda_exames_id);
            $this->db->set('procedimento_convenio_id', $procedimento_convenio_id);
            $this->db->set('desconto', $desconto);
            $this->db->set('ajuste', $ajuste1);
            $this->db->set('valor_total', $valor_proc);
            $this->db->set('valor', $valorajuste1);
            $this->db->set('valor_bruto', $valor_bruto);
            $this->db->set('data', $data);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('faturado', 't');
            $this->db->insert('tb_agenda_exames_faturar');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            // }
        } catch (Exception $exc) {
            return -1;
        }
    }

    function buscarValorExistentePagamento($agenda_exames_id = null) {

        $this->db->select('
                            aef.agenda_exames_id,
                            aef.valor_total,
                            (aef.valor_total - (select sum(valor_bruto) + sum(desconto)  as valorTotPag from ponto.tb_agenda_exames_faturar aef2
                            where aef2.agenda_exames_id = aef.agenda_exames_id and ativo = true)) as valor_restante
                            ', false);
        $this->db->from('tb_agenda_exames_faturar aef');
        $this->db->where('aef.agenda_exames_id', $agenda_exames_id);
        $this->db->where('aef.ativo', 't');
        $this->db->groupby('aef.agenda_exames_id,
                            aef.valor_total,
                            ');
        $return = $this->db->get();
        $retorno = $return->result();

        return $retorno;
        // echo '<pre>';
        // var_dump($retorno); die;
    }

    function gravarprocedimentosfaturarmodelo2() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // echo '<pre>';
            // var_dump($_POST);
            // die;
            $desconto = (float) $_POST['desconto'];
            $valor1 = (float) $_POST['valor1'];
            $valorafaturar = (float) $_POST['valorafaturar'];
            $ajuste1 = (float) $_POST['ajuste1'];
            $valor_bruto = (float) $_POST['valor1'];
            $valorajuste1 = (float) round($_POST['valorajuste1'], 2);
            $valor_proc = (float) $_POST['valor_proc'];
            $parcela1 = (int) $_POST['parcela1'];
            $guia_id = $_POST['guia_id'];

            $forma_pagamento_id = $_POST['forma_pagamento_id'];
            $data = date("Y-m-d");

            $array_examesPG = $_POST['array_exames'];
            $array_valoresPG = $_POST['array_valores'];
            // Os arrays acima vem do POST e são definidos através de uma função do Postgresql
            // aqui eu só faço tratar e deixar como arrays do PHP
            $array_examesStr = str_replace('{', '', str_replace('}', '', $array_examesPG));
            $array_exames = explode(',', $array_examesStr);
            // Array com agenda exames
            $array_valoresStr = str_replace('{', '', str_replace('}', '', $array_valoresPG));
            $array_valores = explode(',', $array_valoresStr);
            // Array com os valores de procedimentos
            // echo '<pre>';
            // var_dump($array_exames); 
            // var_dump($array_valores); 
            // die;
            // Unindo os arrays em um só e ordenando pelo menor valor;
            $i = 0;
            $array_geral = array();
            foreach ($array_exames as $agenda_exames) {
                // Se ja existir um pagamento pra esse agenda_exames,
                // eu tenho que ordenar os valores utilizando o valor restante existente
                // ex: 3 proc custam 120, mas um só falta pagar 90, então ele coloca o de 90 primeiro
                // daí eu ordeno o array corretamente e reatribuo os valores iniciais dos procedimentos
                $valorExi_Array = $this->buscarValorExistentePagamento($agenda_exames);
                if (count($valorExi_Array) > 0) {
                    $array_geral[$agenda_exames] = (float) $valorExi_Array[0]->valor_restante;
                } else {
                    $array_geral[$agenda_exames] = (float) $array_valores[$i];
                }
                $i++;
            }
            asort($array_geral);

            $i = 0;
            // daí eu ordeno o array corretamente e reatribuo os valores iniciais dos procedimentos nesse foreach
            foreach ($array_exames as $agenda_exames) {
                // $valorExi_Array = $this->buscarValorExistentePagamento($agenda_exames);
                $array_geral[$agenda_exames] = (float) $array_valores[$i];
                $i++;
            }
            // asort($array_geral);

            $contador = 0;
            $qtdeProc = count($array_exames);
            $qtdeProcRes = count($array_exames);
            $valorForRestante = $valor_bruto;
            // $valorForRestante = $valorajuste1;
            $valorDescRestante = $desconto;
            $valorDescTotal = 0;
            $valorForTotal = 0;
            $teste = 0;
            $valor_desconto = 0;
            $valorTotalProc = 0;
            $teste_de_valor = 0;
            $valor_ajustado = 0;
            $valorProcExis = null;
            $permissaoInsert = true;
            // $valorProcExi = null;
            $valorAjusteCalculado = 0;
            $valorDivisao = (float) round($valorForRestante / $qtdeProc, 2);
            $valorDescDivisao = (float) round($desconto / $qtdeProc, 2);
            $valor_ajusteAdicional = 0;
            // Divide o valor igualmente por procedimento

            foreach ($array_geral as $agenda_exames_id => $valor) {
                $contador++;

                $valorProcAtual = $valor;
                $valorProcExis = $this->buscarValorExistentePagamento($agenda_exames_id);
                // Se o procedimento atual já existir e não tiver nada restante, ele não insere mais pagamentos
                // Se existir e o valor for maior que zero, ele define o valor a ser pago como o restante
                // Caso contrário, ele vai pegar o valor que vem do POST e percorrer
                if (count($valorProcExis) > 0) {
                    if ($valorProcExis[0]->valor_restante == 0) {
                        $valorPagarAtual = $valorProcExis[0]->valor_restante;
                        $permissaoInsert = false;
                        // echo 'te';
                    } elseif ($valorProcExis[0]->valor_restante > 0) {
                        $valorPagarAtual = $valorProcExis[0]->valor_restante;
                        $permissaoInsert = true;
                    }
                } else {
                    $valorPagarAtual = $valorProcAtual;
                    $permissaoInsert = true;
                }
                // var_dump($valorProcExis);
                // echo "$agenda_exames_id Valor do Proc: $valorProcAtual Valor Vindo do Inicio: $valorPagarAtual <br><hr>";
                // Caso o valor da divisao seja maior que o proc
                // ele vai refazer o calculo da divisao tirando o valor do proc pago e
                // e retirando um da quantidade, já que ele foi pago.
                if ($valorDivisao > $valorPagarAtual) {
                    $valor_pago = $valorPagarAtual;
                    $valorForRestante -= $valor_pago;
                    $qtdeProcRes--; // Subtrai um
                    if ($qtdeProcRes < 1) {
                        $qtdeProcRes = 1; // Nao se divide nada por zero.
                    }
                    $valorDivisao = (float) round($valorForRestante / $qtdeProcRes, 2);
                    $valorDescDivisao = (float) round($valorDescRestante / $qtdeProcRes, 2);
                    $valor_desconto = 0;
                } else {
                    $qtdeProcRes--;

                    $valor_pago = $valorDivisao;
                    $valorForRestante -= $valor_pago;

                    if ($valorDescRestante > 0) {
                        $valor_calculo = $valorDescDivisao + $valor_pago;
                        if ($valor_calculo > $valorPagarAtual) {
                            $valor_desconto = $valorPagarAtual - $valor_pago;
                            $valorDescRestante -= $valor_desconto;
                            if ($qtdeProcRes < 1) { // Nada se divide por zero, lembre-se da matemática.
                                $qtdeProcRes = 1;
                            }
                            $valorDescDivisao = (float) round($valorDescRestante / $qtdeProcRes, 2);
                        } else {
                            $valorDescRestante -= $valorDescDivisao;
                            $valor_desconto = $valorDescDivisao;
                        }
                        $valorDescTotal += $valor_desconto;
                    }
                }

                $valorForTotal += $valor_pago;
                $valorTotalProc += $valorPagarAtual;
                // Aqui eu verifico se o foreach chegou no fim
                if ($contador >= count($array_geral)) {
                    // Se sim, olho se restou alguns centavos ou coisa do tipo no valor
                    // caso sobre, eu só faço somar ao último valor que ele vai inserir
                    if ($valorForRestante != 0) {
                        $valor_pago += $valorForRestante;
                        $valorForTotal += $valorForRestante;
                    }
                    if ($valorDescRestante != 0) {
                        $valor_desconto += $valorDescRestante;
                        $valorDescTotal += $valorDescRestante;
                        $valorDescRestante -= $valorDescRestante;
                    }
                }

                if ($ajuste1 > 0) {
                    $valor_ajustado = round($valor_pago + ($valor_pago * ($ajuste1 / 100)), 2);
                } else {
                    // $valor_ajustado = $valor_pago;
                }
                $valorAjusteCalculado += $valor_ajustado;

                if ($contador >= count($array_geral)) {

                    if ($valorajuste1 > $valorAjusteCalculado && $ajuste1 > 0) {
                        $restoAjuste = $valorajuste1 - $valorAjusteCalculado;
                        $valor_ajusteAdicional = $restoAjuste;
                    }
                }
                // Depois de ver se tem algum centavo perdido, ele vai inserir no valor bruto o certo
                $valor_bruto_ins = $valor_pago;
                // echo "$valor_ajustado <br>";
                // echo " Valor do Proc: $valorPagarAtual Valor a ser pago: $valor_pago com desconto de: $valor_desconto <br>";
                // Abaixo o insert na tabela de pagamentos
                // Caso o procedimento não esteja totalmente pago, ele vai fazer insert da forma
                // $permissaoInsert = false;
                if ($permissaoInsert) {

                    $this->db->set('forma_pagamento_id', $forma_pagamento_id);
                    $this->db->set('parcela', $parcela1);
                    $this->db->set('guia_id', $guia_id);
                    $this->db->set('agenda_exames_id', $agenda_exames_id);
                    // $this->db->set('procedimento_convenio_id', $procedimento_convenio_id);
                    $this->db->set('desconto', $valor_desconto);
                    $this->db->set('ajuste', $ajuste1);
                    $this->db->set('valor_total', $valorProcAtual);
                    $this->db->set('valor', $valor_pago);
                    $this->db->set('valor_bruto', $valor_bruto_ins);
                    $this->db->set('data', $data);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->set('faturado_guia', 't');
                    $this->db->insert('tb_agenda_exames_faturar');


                    // Ajustando o valor do procedimento baseado no ajuste do cartão
                    if ($ajuste1 > 0) {
                        $sql = "UPDATE ponto.tb_agenda_exames_faturar
                    SET valor = valor_bruto + $valor_ajusteAdicional + (valor_bruto * (ajuste/100)) 
                    WHERE agenda_exames_id = $agenda_exames_id;";
                        $this->db->query($sql);
                    }
                }



                // echo '<hr>';
            }

            // echo '<hr>';
            // echo "Valor dos procs: $valorTotalProc  Valor total calculado:  $valorForTotal e o valor ajustado: $valorajuste1 e o valor ajustado calculado $valorAjusteCalculado Valor do Desconto foi de: $valorDescTotal. Desconto restante de: $valorDescRestante";
            // die;

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
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

            $desconto_cartao1 = $_POST['valor1'] - $_POST['valorajuste1'];
            $desconto_cartao2 = $_POST['valor2'] - $_POST['valorajuste2'];
            $desconto_cartao3 = $_POST['valor3'] - $_POST['valorajuste3'];
            $desconto_cartao4 = $_POST['valor4'] - $_POST['valorajuste4'];
//            echo '<pre>';
//            var_dump($desconto_cartao1,$desconto_cartao2,$desconto_cartao3,$desconto_cartao4 );
//            die;


            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if ($_POST['formapamento1'] != '') {
                $this->db->set('forma_pagamento', $_POST['formapamento1']);
                $this->db->set('valor1', (float) str_replace(",", ".", $valor1));
                $this->db->set('parcelas1', $_POST['parcela1']);
                $this->db->set('desconto_ajuste1', $desconto_cartao1);
            }
            if ($_POST['formapamento2'] != '') {
                $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                $this->db->set('valor2', (float) str_replace(",", ".", $valor2));
                $this->db->set('parcelas2', $_POST['parcela2']);
                $this->db->set('desconto_ajuste2', $desconto_cartao2);
            }
            if ($_POST['formapamento3'] != '') {
                $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                $this->db->set('valor3', (float) str_replace(",", ".", $valor3));
                $this->db->set('parcelas3', $_POST['parcela3']);
                $this->db->set('desconto_ajuste3', $desconto_cartao3);
            }
            if ($_POST['formapamento4'] != '') {
                $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                $this->db->set('valor4', (float) str_replace(",", ".", $valor4));
                $this->db->set('parcelas4', $_POST['parcela4']);
                $this->db->set('desconto_ajuste4', $desconto_cartao4);
            }
            $this->db->set('desconto', $desconto);
            $this->db->set('valor_total', $_POST['novovalortotal']);
            $this->db->set('data_faturamento', $horario);
            $this->db->set('operador_faturamento', $operador_id);
            $this->db->set('faturado', 't');
            $this->db->set('observacao', $_POST['observacao']);
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravartransformaorcamentocredito() {
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

            $desconto_cartao1 = $_POST['valor1'] - $_POST['valorajuste1'];
            $desconto_cartao2 = $_POST['valor2'] - $_POST['valorajuste2'];
            $desconto_cartao3 = $_POST['valor3'] - $_POST['valorajuste3'];
            $desconto_cartao4 = $_POST['valor4'] - $_POST['valorajuste4'];

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if ($_POST['formapamento1'] != '') {
                $this->db->set('forma_pagamento1', $_POST['formapamento1']);
                $this->db->set('valor1', str_replace(",", ".", $valor1));
                $this->db->set('parcelas1', $_POST['parcela1']);
                $this->db->set('desconto_ajuste1', $desconto_cartao1);
            }
            if ($_POST['formapamento2'] != '') {
                $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                $this->db->set('valor2', str_replace(",", ".", $valor2));
                $this->db->set('parcelas2', $_POST['parcela2']);
                $this->db->set('desconto_ajuste2', $desconto_cartao2);
            }
            if ($_POST['formapamento3'] != '') {
                $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                $this->db->set('valor3', str_replace(",", ".", $valor3));
                $this->db->set('parcelas3', $_POST['parcela3']);
                $this->db->set('desconto_ajuste3', $desconto_cartao3);
            }
            if ($_POST['formapamento4'] != '') {
                $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                $this->db->set('valor4', str_replace(",", ".", $valor4));
                $this->db->set('parcelas4', $_POST['parcela4']);
                $this->db->set('desconto_ajuste4', $desconto_cartao4);
            }

            $paciente_id = $_POST['paciente_id'];

            $this->db->set('faturado', 't');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('valor', (float) str_replace(',', '.', str_replace('.', '', $_POST['valorafaturar'])));
            $this->db->set('data', date("Y-m-d"));

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->insert('tb_paciente_credito');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravartransformaorcamentocreditopersonalizado() {
        try {

            $valor1 = $_POST['valor1'];
            $valor2 = $_POST['valor2'];
            $valor3 = $_POST['valor3'];
            $valor4 = $_POST['valor4'];

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if ($_POST['formapamento1'] != '') {
                $this->db->set('forma_pagamento1', $_POST['formapamento1']);
                $this->db->set('valor1', str_replace(",", ".", $valor1));
                $this->db->set('parcelas1', 1);
                $this->db->set('desconto_ajuste1', 0);
            }
            if ($_POST['formapamento2'] != '') {
                $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                $this->db->set('valor2', str_replace(",", ".", $valor2));
                $this->db->set('parcelas2', 1);
                $this->db->set('desconto_ajuste2', 0);
            }
            if ($_POST['formapamento3'] != '') {
                $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                $this->db->set('valor3', str_replace(",", ".", $valor3));
                $this->db->set('parcelas3', 1);
                $this->db->set('desconto_ajuste3', 0);
            }
            if ($_POST['formapamento4'] != '') {
                $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                $this->db->set('valor4', str_replace(",", ".", $valor4));
                $this->db->set('parcelas4', 1);
                $this->db->set('desconto_ajuste4', 0);
            }

            $paciente_id = $_POST['paciente_id'];

            $this->db->set('faturado', 't');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('valor', (float) str_replace(',', '.', str_replace('.', '', $_POST['valorafaturar'])));
            $this->db->set('data', date("Y-m-d"));

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $empresa_id = $this->session->userdata('empresa_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->insert('tb_paciente_credito');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentocredito() {
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

            $desconto_cartao1 = $_POST['valor1'] - $_POST['valorajuste1'];
            $desconto_cartao2 = $_POST['valor2'] - $_POST['valorajuste2'];
            $desconto_cartao3 = $_POST['valor3'] - $_POST['valorajuste3'];
            $desconto_cartao4 = $_POST['valor4'] - $_POST['valorajuste4'];
//            echo '<pre>';
//            var_dump($_POST);
//            die;


            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if ($_POST['formapamento1'] != '') {
                $this->db->set('forma_pagamento1', $_POST['formapamento1']);
                $this->db->set('valor1', str_replace(",", ".", $valor1));
                $this->db->set('parcelas1', $_POST['parcela1']);
                $this->db->set('desconto_ajuste1', $desconto_cartao1);
            }
            if ($_POST['formapamento2'] != '') {
                $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                $this->db->set('valor2', str_replace(",", ".", $valor2));
                $this->db->set('parcelas2', $_POST['parcela2']);
                $this->db->set('desconto_ajuste2', $desconto_cartao2);
            }
            if ($_POST['formapamento3'] != '') {
                $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                $this->db->set('valor3', str_replace(",", ".", $valor3));
                $this->db->set('parcelas3', $_POST['parcela3']);
                $this->db->set('desconto_ajuste3', $desconto_cartao3);
            }
            if ($_POST['formapamento4'] != '') {
                $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                $this->db->set('valor4', str_replace(",", ".", $valor4));
                $this->db->set('parcelas4', $_POST['parcela4']);
                $this->db->set('desconto_ajuste4', $desconto_cartao4);
            }
//            $this->db->set('desconto', $desconto);
//            $this->db->set('valor_total', $_POST['totalpagar']);
            $this->db->set('ativo', 't');
            $this->db->set('faturado', 't');
            $this->db->where('paciente_credito_id', $_POST['credito_id']);
            $this->db->update('tb_paciente_credito');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturarcreditopersonalizado() {
        try {

            $desconto = $_POST['desconto'];
            $valor1 = $_POST['valor1'];
            $valor2 = $_POST['valor2'];
            $valor3 = $_POST['valor3'];
            $valor4 = $_POST['valor4'];

            if ($_POST['formapamento1'] != '') {
                $this->db->set('forma_pagamento1', $_POST['formapamento1']);
                $this->db->set('valor1', (float) str_replace(",", ".", $valor1));
                $this->db->set('parcelas1', 1);
                $this->db->set('desconto_ajuste1', 0);
            }
            if ($_POST['formapamento2'] != '') {
                $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                $this->db->set('valor2', (float) str_replace(",", ".", $valor2));
                $this->db->set('parcelas2', 1);
                $this->db->set('desconto_ajuste2', 0);
            }
            if ($_POST['formapamento3'] != '') {
                $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                $this->db->set('valor3', (float) str_replace(",", ".", $valor3));
                $this->db->set('parcelas3', 1);
                $this->db->set('desconto_ajuste3', 0);
            }
            if ($_POST['formapamento4'] != '') {
                $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                $this->db->set('valor4', (float) str_replace(",", ".", $valor4));
                $this->db->set('parcelas4', 1);
                $this->db->set('desconto_ajuste4', 0);
            }

            $this->db->set('ativo', 't');
            $this->db->set('faturado', 't');
            $this->db->where('paciente_credito_id', $_POST['credito_id']);
            $this->db->update('tb_paciente_credito');
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
            $dataautorizacao = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))) . " " . $hora;
            // var_dump($dataautorizacao);
            // die;
            $sql = "UPDATE ponto.tb_agenda_exames
                    SET data_antiga = data
                    WHERE agenda_exames_id = $agenda_exames_id;";

            $this->db->query($sql);

//            $this->db->set('data_antiga', 'data');
            $this->db->set('data_aterardatafaturamento', $horario);
            $this->db->set('data_autorizacao', $dataautorizacao);
            $this->db->set('operador_aterardatafaturamento', $operador_id);
            $this->db->set('data', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))));
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaralterardatacadastroaso($exames_id, $aso_id) {
        try {
//            var_dump($aso_id);die;
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $data = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data'])));
            $result = date('Y-m-d', strtotime("+365 days", strtotime($data)));

            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('data_aso', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))));
            $this->db->set('data_validade', $result);
            $this->db->where('cadastro_aso_id', $aso_id);
            $this->db->update('tb_cadastro_aso');

            $this->db->set('data', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))));
            $this->db->where('agenda_exames_id', $exames_id);
            $this->db->update('tb_agenda_exames');

            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaralterardatafaturamento($agenda_exames_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $dataautorizacao = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))) . " " . $hora;
//            var_dump($dataautorizacao);
//            die;
            $sql = "UPDATE ponto.tb_agenda_exames
                    SET data_antiga = data_faturar
                    WHERE agenda_exames_id = $agenda_exames_id;";

            $this->db->query($sql);

//            $this->db->set('data_antiga', 'data');
            $this->db->set('data_aterardatafaturamento', $horario);
            $this->db->set('data_autorizacao', $dataautorizacao);
            $this->db->set('operador_aterardatafaturamento', $operador_id);
            $this->db->set('data_faturar', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))));
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaralterarautorizacao($agenda_exames_id) {
        try {
//            var_dump($_POST); die;
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_alterarautorizacao', $horario);
            $this->db->set('operador_alterarautorizacao', $operador_id);
            $this->db->set('autorizacao', $_POST['autorizacao']);
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
            if($_POST['carater_xml'] > 0){
                $this->db->set('carater_xml', $_POST['carater_xml']);
            }
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

    function desfazerfaturamentoconvenio($agenda_exames_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('valor1', 0);

            $this->db->set('data_ajuste_faturamento', $horario);
            $this->db->set('operador_ajuste_faturamento', $operador_id);
            $this->db->set('faturado', 'f');
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentoconveniostatus() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('situacao_faturamento', $_POST['status']);
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentodetalhe($percentual) {
        try {
            /* inicia o mapeamento no banco ae.medico_agenda */
            if ($_POST['guiaconvenio'] != '') {
                $this->db->set('guiaconvenio', $_POST['guiaconvenio']);
                $this->db->where('ambulatorio_guia_id', $_POST['ambulatorio_guia_id']);
                $this->db->update('tb_ambulatorio_guia');
            }


            if ($_POST['medico_solicitante'] != '') {
                $this->db->set('medico_solicitante', $_POST['medico_solicitante']);
            }

            if ($_POST['autorizacao'] != '') {
                $this->db->set('autorizacao', $_POST['autorizacao']);
            }
            $this->db->set('guiaconvenio', $_POST['guiaconvenio']);
            $this->db->set('agenda_exames_nome_id', $_POST['sala']);
            $this->db->set('medico_agenda', $_POST['medico']);
            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
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

    function relatorioresumocreditoslancados() {
        $this->db->select(" pc.valor,
                            p.nome as paciente,
                            pc.data,
                            o.nome as operador,
                            f.forma_pagamento_id,
                            f.nome as formapagamento,
                            pc.valor1,
                            pc.valor2,
                            pc.valor3,
                            pc.valor4,
                            f.nome as forma_pagamento,
                            f2.nome as forma_pagamento_2,
                            f3.nome as forma_pagamento_3,
                            f4.nome as forma_pagamento_4");
        $this->db->from('tb_paciente_credito pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = pc.operador_cadastro', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = pc.forma_pagamento1', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = pc.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = pc.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = pc.forma_pagamento4', 'left');
        $this->db->where("pc.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("pc.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['empresa'] != '0') {
            $this->db->where('pc.empresa_id', $_POST['empresa']);
        }
        $this->db->where("pc.ativo", 't');
        $query = $this->db->get();
        $return = $query->result();
        return $return;
    }

    function relatoriocaixacreditoslancados() {
        $this->db->select("pc.valor,
                            p.nome as paciente,
                            pc.data,
                            pc.faturado,
                            pc.financeiro_fechado,
                            pc.forma_pagamento_id,
                            pc.valor1,
                            pc.valor2,
                            pc.valor3,
                            pc.valor4,
                            f.nome as forma_pagamento,
                            f2.nome as forma_pagamento_2,
                            f3.nome as forma_pagamento_3,
                            f4.nome as forma_pagamento_4,
                            f.nome as formapagamento");
        $this->db->from('tb_paciente_credito pc');
        $this->db->join('tb_paciente p', 'p.paciente_id = pc.paciente_id', 'left');
//        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = pc.forma_pagamento_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = pc.forma_pagamento1', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = pc.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = pc.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = pc.forma_pagamento4', 'left');
        $this->db->where("pc.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("pc.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        if ($_POST['empresa'] != '') {
            $this->db->where('pc.empresa_id', $_POST['empresa']);
        }
        $this->db->where("pc.ativo", 't');
//        $this->db->groupby("p.nome, pc.data, f.forma_pagamento_id, f.nome");
        $query = $this->db->get();
        $return = $query->result();
        return $return;
    }

    function descontacreditopaciente() {
        // Pega o valor de crédito que esta sendo usado
        if ($_POST['formapamento1'] == 1000) {
            $valor = $_POST['valor1'];
        } elseif ($_POST['formapamento2'] == 1000) {
            $valor = $_POST['valor2'];
        } elseif ($_POST['formapamento3'] == 1000) {
            $valor = $_POST['valor3'];
        } elseif ($_POST['formapamento4'] == 1000) {
            $valor = $_POST['valor4'];
        } else {
            $valor = 0;
        }

        if ($_POST['agenda_exames_id'] != '') {
            $this->db->set('ativo', 'f');
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->where('valor < 0');
            $this->db->update('tb_paciente_credito');
        }

        $this->db->set('valor', (-1) * (float) $valor);
        $this->db->set('paciente_id', $_POST['paciente_id']);

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        if ($_POST['agenda_exames_id'] != '') {
            $this->db->set('agenda_exames_id', $_POST['agenda_exames_id']);
        }
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_paciente_credito');
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
                    $desconto1 = $_POST['valor1'] - $_POST['valorajuste1'];
//                    $desconto1 = $_POST['valorajuste1'] - $_POST['valor1'];
                }
                if ($_POST['valor2'] > $_POST['valorajuste2']) {
                    $desconto2 = $_POST['valor2'] - $_POST['valorajuste2'];
                } else {
                    $desconto2 = $_POST['valor2'] - $_POST['valorajuste2'];
//                    $desconto2 = $_POST['valorajuste2'] - $_POST['valor2'];
                }
                if ($_POST['valor3'] > $_POST['valorajuste3']) {
                    $desconto3 = $_POST['valor3'] - $_POST['valorajuste3'];
                } else {
                    $desconto3 = $_POST['valor3'] - $_POST['valorajuste3'];
//                    $desconto3 = $_POST['valorajuste3'] - $_POST['valor3'];
                }
                if ($_POST['valor4'] > $_POST['valorajuste4']) {
                    $desconto4 = $_POST['valor4'] - $_POST['valorajuste4'];
                } else {
                    $desconto4 = $_POST['valor4'] - $_POST['valorajuste4'];
//                    $desconto4 = $_POST['valorajuste4'] - $_POST['valor4'];
                }

                $desconto = $desconto1 + $desconto2 + $desconto3 + $desconto4 + $_POST['desconto'];
            } else {
                $desconto = $_POST['desconto'];
            }

//            $desconto = $_POST['desconto'];
//            $valor1 = $_POST['valor1'];
//            $valor2 = $_POST['valor2'];
//            $valor3 = $_POST['valor3'];
//            $valor4 = $_POST['valor4'];

            $desconto_cartao1 = $_POST['valor1'] - $_POST['valorajuste1'];
            $desconto_cartao2 = $_POST['valor2'] - $_POST['valorajuste2'];
            $desconto_cartao3 = $_POST['valor3'] - $_POST['valorajuste3'];
            $desconto_cartao4 = $_POST['valor4'] - $_POST['valorajuste4'];
//            echo '<pre>';
//            var_dump($desconto);
//            die;
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
//            echo '<pre>';
//            var_dump($value->valor_total);
//            var_dump($desconto);
//            var_dump($valor1);
//            var_dump($valortotal);
//            die;
                $i = 0;
                if ($valor1 > 0 && $valor1 >= $valortotal) {
//                    echo 'if1';
                    $valor1 = $valor1 - $valortotal;
                    $this->db->set('forma_pagamento', $_POST['formapamento1']);
                    $this->db->set('valor1', str_replace(",", ".", $valortotal));
                    $this->db->set('desconto_ajuste1', $desconto_cartao1);
                    $this->db->set('parcelas1', $_POST['parcela1']);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $i = 1;
                } elseif ($i != 1 && $valor2 > 0 && $valor1 < $valortotal && $valor2 >= ($valortotal - $valor1)) {
//                    echo 'if2';
                    $valor2 = $valor2 - ($valortotal - $valor1);
                    $restovalor2 = $valortotal - $valor1;
                    if ($valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
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
//                    echo 'if3';
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
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
                    }
                    if ($valor1 == 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    if ($valor2 == 0 && $valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
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
//                    echo 'if4';
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
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    if ($valor1 == 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
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
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
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
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas1', $_POST['parcela3']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    if ($valor2 == 0 && $valor1 > 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    if ($valor2 > 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento4']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas1', $_POST['parcela4']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
//                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
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
//            die;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentototalprocedimentospersonalizado() {
        try {

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
            $this->db->where('faturado', 'f');
            $this->db->where('confirmado', 'true');
            $query = $this->db->get();
            $returno = $query->result();

            $desconto = $_POST['desconto'];

            $this->db->set('operador_id', $operador_id);
            $this->db->set('agenda_exames_id', $returno[0]->agenda_exames_id);
            $this->db->set('valor_total', $desconto);
            $this->db->set('guia_id', $returno[0]->guia_id);
            $this->db->set('paciente_id', $returno[0]->paciente_id);
            $this->db->insert('tb_ambulatorio_desconto');

            $valor1 = $_POST['valor1'];
            $valor2 = $_POST['valor2'];
            $valor3 = $_POST['valor3'];
            $valor4 = $_POST['valor4'];

            $forma1 = $_POST['formapamento1'];
            $forma2 = $_POST['formapamento2'];
            $forma3 = $_POST['formapamento3'];
            $forma4 = $_POST['formapamento4'];

            $id_juros = $returno[0]->agenda_exames_id;
            $valortotal_juros = $returno[0]->valor_total;
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
//                    echo 'if1';
                    $valor1 = $valor1 - $valortotal;
                    $this->db->set('forma_pagamento', $_POST['formapamento1']);
                    $this->db->set('valor1', str_replace(",", ".", $valortotal));
                    $this->db->set('desconto_ajuste1', 0);
                    $this->db->set('parcelas1', 1);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $i = 1;
                } elseif ($i != 1 && $valor2 > 0 && $valor1 < $valortotal && $valor2 >= ($valortotal - $valor1)) {
//                    echo 'if2';
                    $valor2 = $valor2 - ($valortotal - $valor1);
                    $restovalor2 = $valortotal - $valor1;
                    if ($valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('desconto_ajuste1', 0);
                        $this->db->set('desconto_ajuste2', 0);
                        $this->db->set('parcelas1', 1);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor2));
                        $this->db->set('parcelas2', 1);
                    }
                    if ($valor1 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor2));
                        $this->db->set('parcelas1', 1);
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
//                    echo 'if3';
                    $valor3 = $valor3 - ($valortotal - ($valor2 + $valor1));
                    $restovalor3 = $valortotal - ($valor2 + $valor1);
                    if ($valor1 > 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', 1);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', 1);
                        $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas3', 1);
                        $this->db->set('desconto_ajuste1', 0);
                        $this->db->set('desconto_ajuste2', 0);
                        $this->db->set('desconto_ajuste3', 0);
                    }
                    if ($valor1 == 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', 1);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', 1);
                        $this->db->set('desconto_ajuste1', 0);
                        $this->db->set('desconto_ajuste2', 0);
//                        $this->db->set('desconto_ajuste3', 0);
//                        $this->db->set('desconto_ajuste4', 0);
                    }
                    if ($valor2 == 0 && $valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', 1);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', 1);
                        $this->db->set('desconto_ajuste1', 0);
                        $this->db->set('desconto_ajuste2', 0);
//                        $this->db->set('desconto_ajuste3', 0);
//                        $this->db->set('desconto_ajuste4', 0);
                    }
                    if ($valor2 == 0 && $valor1 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas1', 1);
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
//                    echo 'if4';
                    $valor4 = $valor4 - ($valortotal - ($valor3 + $valor2 + $valor1));
                    $restovalor4 = $valortotal - ($valor3 + $valor2 + $valor1);
                    if ($valor1 > 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', 1);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', 1);
                        $this->db->set('forma_pagamento3', $_POST['formapamento3']);
                        $this->db->set('valor3', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', 1);
                        $this->db->set('forma_pagamento4', $_POST['formapamento4']);
                        $this->db->set('valor4', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas4', 1);
                        $this->db->set('desconto_ajuste1', 0);
                        $this->db->set('desconto_ajuste2', 0);
                        $this->db->set('desconto_ajuste3', 0);
                        $this->db->set('desconto_ajuste4', 0);
                    }
                    if ($valor1 == 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('desconto_ajuste1', 0);
                        $this->db->set('desconto_ajuste2', 0);
                        $this->db->set('desconto_ajuste3', 0);
//                        $this->db->set('desconto_ajuste4', 0);
                        $this->db->set('parcelas1', 1);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', 1);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', 1);
                    }
                    if ($valor2 == 0 && $valor1 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', 1);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas2', 1);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', 1);
                        $this->db->set('desconto_ajuste1', 0);
                        $this->db->set('desconto_ajuste2', 0);
                        $this->db->set('desconto_ajuste3', 0);
//                        $this->db->set('desconto_ajuste4', 0);
                    }
                    if ($valor2 > 0 && $valor1 > 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', 1);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas2', 1);
                        $this->db->set('forma_pagamento3', $_POST['formapamento4']);
                        $this->db->set('valor3', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas3', 1);
                        $this->db->set('desconto_ajuste1', 0);
                        $this->db->set('desconto_ajuste2', 0);
                        $this->db->set('desconto_ajuste3', 0);
//                        $this->db->set('desconto_ajuste4', 0);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas1', 1);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', 1);
                        $this->db->set('desconto_ajuste1', 0);
                        $this->db->set('desconto_ajuste2', 0);
//                        $this->db->set('desconto_ajuste3', 0);
//                        $this->db->set('desconto_ajuste4', 0);
                    }
                    if ($valor2 == 0 && $valor1 > 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', 1);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', 1);
                        $this->db->set('desconto_ajuste1', 0);
                        $this->db->set('desconto_ajuste2', 0);
//                        $this->db->set('desconto_ajuste3', 0);
//                        $this->db->set('desconto_ajuste4', 0);
                    }
                    if ($valor2 > 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', 1);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', 1);
                        $this->db->set('desconto_ajuste1', 0);
                        $this->db->set('desconto_ajuste2', 0);
//                        $this->db->set('desconto_ajuste3', 0);
//                        $this->db->set('desconto_ajuste4', 0);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento4']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas1', 1);
                        $this->db->set('desconto_ajuste1', 0);
//                        $this->db->set('desconto_ajuste2', 0);
//                        $this->db->set('desconto_ajuste3', 0);
//                        $this->db->set('desconto_ajuste4', 0);
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
//            die;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarfaturamentototalprocedimentos() {
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

                $desconto = $desconto1 + $desconto2 + $desconto3 + $desconto4 + $_POST['desconto'];
            } else {
                $desconto = $_POST['desconto'];
            }

//            $desconto = $_POST['desconto'];
//            $valor1 = $_POST['valor1'];
//            $valor2 = $_POST['valor2'];
//            $valor3 = $_POST['valor3'];
//            $valor4 = $_POST['valor4'];

            $desconto_cartao1 = $_POST['valor1'] - $_POST['valorajuste1'];
            $desconto_cartao2 = $_POST['valor2'] - $_POST['valorajuste2'];
            $desconto_cartao3 = $_POST['valor3'] - $_POST['valorajuste3'];
            $desconto_cartao4 = $_POST['valor4'] - $_POST['valorajuste4'];
//            echo '<pre>';
//            var_dump($desconto_cartao1,$desconto_cartao2,$desconto_cartao3,$desconto_cartao4 );
//            die;
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
            $this->db->where('faturado', 'f');
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
//            echo '<pre>';
//            var_dump($returno);
//            var_dump($desconto);
//            var_dump($valor1);
//            var_dump($valortotal);
//            die;
                $i = 0;
                if ($valor1 > 0 && $valor1 >= $valortotal) {
//                    echo 'if1';
                    $valor1 = $valor1 - $valortotal;
                    $this->db->set('forma_pagamento', $_POST['formapamento1']);
                    $this->db->set('valor1', str_replace(",", ".", $valortotal));
                    $this->db->set('desconto_ajuste1', $desconto_cartao1);
                    $this->db->set('parcelas1', $_POST['parcela1']);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->set('observacao', $_POST['observacao']);
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $i = 1;
                } elseif ($i != 1 && $valor2 > 0 && $valor1 < $valortotal && $valor2 >= ($valortotal - $valor1)) {
//                    echo 'if2';
                    $valor2 = $valor2 - ($valortotal - $valor1);
                    $restovalor2 = $valortotal - $valor1;
                    if ($valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
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
                    $this->db->set('observacao', $_POST['observacao']);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor1 = 0;
                    $i = 2;
                } elseif ($i != 1 && $i != 2 && $valor3 > 0 && $valor2 < $valortotal && $valor3 >= ($valortotal - ($valor1 + $valor2))) {
//                    echo 'if3';
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
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
                    }
                    if ($valor1 == 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    if ($valor2 == 0 && $valor1 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento3']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas2', $_POST['parcela3']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
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
                    $this->db->set('observacao', $_POST['observacao']);
                    $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $valor2 = 0;
                    $valor1 = 0;
                    $i = 3;
                } elseif ($i != 1 && $i != 2 && $i != 3 && $valor2 < ($valortotal - $valor1) && $valor3 < ($valortotal - ($valor1 + $valor2)) && $valor4 >= ($valortotal - ($valor1 + $valor2 + $valor3))) {
//                    echo 'if4';
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
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    if ($valor1 == 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
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
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
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
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $valor3));
                        $this->db->set('parcelas1', $_POST['parcela3']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    if ($valor2 == 0 && $valor1 > 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    if ($valor2 > 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $valor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento4']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas2', $_POST['parcela4']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    if ($valor2 == 0 && $valor1 == 0 && $valor3 == 0) {
                        $this->db->set('forma_pagamento', $_POST['formapamento4']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas1', $_POST['parcela4']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
//                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor_total', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->set('observacao', $_POST['observacao']);
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
//            die;
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

    function gravarfaturamentomanualtotalconvenio() {
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
                if($_POST['carater_xml'] > 0){
                    $this->db->set('carater_xml', $_POST['carater_xml']);
                }
                $this->db->set('faturado', 't');
                $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function desfazerfaturamentototalconvenio($guia_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            $this->db->select('agenda_exames_id, valor_total');
            $this->db->from('tb_agenda_exames');
            $this->db->where("guia_id", $guia_id);
            $query = $this->db->get();
            $returno = $query->result();

            foreach ($returno as $value) {
//                $this->db->set('forma_pagamento', $_POST['formapamento1']);
                $this->db->set('valor1', 0);
                $this->db->set('data_ajuste_faturamento', $horario);
                $this->db->set('operador_ajuste_faturamento', $operador_id);
                $this->db->set('faturado', 'f');
                $this->db->where('agenda_exames_id', $value->agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function relatoriocaixapersonalizadoforma($formapagamento_id) {
//        var_dump($_POST['data1']);die;
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
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("(ae.forma_pagamento  = $formapagamento_id OR ae.forma_pagamento2 = $formapagamento_id OR 
                           ae.forma_pagamento3 = $formapagamento_id OR ae.forma_pagamento4 = $formapagamento_id)");
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.financeiro', 'f');
//        $this->db->where('pt.home_care', 'f');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data1']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data2']))));

        $this->db->where('c.dinheiro', 't');
        if (isset($_POST['empresa'])) {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }

        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixaforma($formapagamento_id) {
//        var_dump($_POST['data1']);die;
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
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("(ae.forma_pagamento  = $formapagamento_id OR ae.forma_pagamento2 = $formapagamento_id OR 
                           ae.forma_pagamento3 = $formapagamento_id OR ae.forma_pagamento4 = $formapagamento_id)");
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('ae.financeiro', 'f');
//        $this->db->where('pt.home_care', 'f');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data1']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data2']))));

        $this->db->where('c.dinheiro', 't');
        if (isset($_POST['empresa'])) {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }

        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixaformacredito($formapagamento_id) {
//        var_dump($_POST['data1']);die;
        $this->db->select('
                            ae.valor1,
                            ae.parcelas1,
                            ae.forma_pagamento1 as forma_pagamento,
                            ae.valor2,
                            ae.parcelas2,
                            ae.forma_pagamento2,
                            ae.valor3,
                            ae.parcelas3,
                            ae.forma_pagamento3,
                            ae.valor4,
                            ae.parcelas4,
                            ae.forma_pagamento4');
        $this->db->from('tb_paciente_credito ae');
        $this->db->where("(ae.forma_pagamento1  = $formapagamento_id OR ae.forma_pagamento2 = $formapagamento_id OR 
                           ae.forma_pagamento3 = $formapagamento_id OR ae.forma_pagamento4 = $formapagamento_id)");
//        $this->db->where('pt.home_care', 'f');
        $this->db->where("ae.data >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data1']))));
        $this->db->where("ae.data <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data2']))));

        if (isset($_POST['empresa'])) {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
        }

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
    
    function burcarcontasreceberModelo2() {
        $this->db->select('sum(valor) as valor,   
                           devedor,
                           parcela,
                           data,
                           observacao,
                           entrada_id,
                           conta,
                           classe');
        $this->db->from('tb_financeiro_contasreceber_temp ct');
        // $this->db->where('data', $data);
        $this->db->where('ativo', 't');
        $this->db->groupby('devedor');
        $this->db->groupby('parcela');
        $this->db->groupby('data');
        $this->db->groupby('observacao');
        // $this->db->groupby('data_cadastro');
        // $this->db->groupby('operador_cadastro');
        $this->db->groupby('entrada_id');
        $this->db->groupby('conta');
        $this->db->groupby('classe');
        $this->db->orderby('devedor');
        $this->db->orderby('parcela');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarParcelaMaxima($devedor){
        // $sql = (select max(parcela) from ponto.tb_financeiro_contasreceber_temp ct2
        // where ct.devedor = ct2.devedor and ct2.ativo = true) as parcela_maxima, 
        $this->db->select('max(parcela)');
                          
        $this->db->from('tb_financeiro_contasreceber_temp ct');
        $this->db->where('devedor', $devedor);
        $this->db->where('ativo', 't');
        $this->db->groupby('devedor');

        $this->db->orderby('devedor');

        $return = $this->db->get();
        return $return->result();
        

    }

    function fecharcaixapersonalizado() {

//        try {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");

        $operador_id = $this->session->userdata('operador_id');
        $data_cauculo = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data1'])));
        $data_inicio = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data1'])));
        $data_fim = $_POST['data2'];
        $observacao = "Periodo de " . $_POST['data1'] . " a " . $_POST['data2'];
        $data = date("Y-m-d");
        $empresa_id = $_POST['empresa'];
        $data30 = date('Y-m-d', strtotime("+30 days", strtotime($data_cauculo)));
        $data4 = date('Y-m-d', strtotime("+4 days", strtotime($data_cauculo)));
        $data2 = date('Y-m-d', strtotime("+2 days", strtotime($data_cauculo)));

        $this->db->select('forma_pagamento_id,
                            nome, 
                            credor_devedor,
                            tempo_receber, 
                            dia_receber,
                            parcelas');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $this->db->where("forma_pagamento_id !=", '1000'); // Forma de pagamento CREDITO não pode ser levada em conta
        $return = $this->db->get();
        $forma_pagamento = $return->result();

        $valor_total = '0.00';

        $teste = $_POST['qtde'];
        foreach ($forma_pagamento as $value) {
            // Selecionando a conta baseada na empresa

            $this->db->select('conta_id');
            $this->db->from('tb_formapagamento_conta_empresa');
            $this->db->where("ativo", 't');
            $this->db->where("forma_pagamento_id", $value->forma_pagamento_id);
            $this->db->where("empresa_id", $empresa_id);

            $conta_array = $this->db->get()->result();

//            var_dump($conta_array); die;
            if (count($conta_array) > 0) {
                $value->conta_id = $conta_array[0]->conta_id;
            } else {
                $value->conta_id = '';
            }
//            var_dump($value->conta_id); die;
            $classe = "CAIXA" . " " . $value->nome;

            foreach ($teste as $j => $t) {
                //Por limitacoes do CodeIgniter, tem que fazer isso.
                $j = strtolower(str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' '), '', $j));
                if ($j == strtolower(str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' '), '', $value->nome))) {
                    $valor_total = (str_replace(".", "", $t));
                    $valor_total = (str_replace(",", ".", $valor_total));
                }
            }

            if ($valor_total != '0.00') {

                if ($value->nome == '' || $value->conta_id == '' || $value->credor_devedor == '' || $value->parcelas == '') {
                    return 10;
                }

                if ((!isset($value->tempo_receber) || $value->tempo_receber == 0) && (!isset($value->dia_receber) || $value->dia_receber == 0)) {

                    $this->db->set('data', $data);
                    $this->db->set('valor', $valor_total);
                    $this->db->set('classe', $classe);
                    $this->db->set('nome', $value->credor_devedor);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('observacao', $observacao);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_entradas');
                    $entradas_id = $this->db->insert_id();

                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('valor', $valor_total);
                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('entrada_id', $entradas_id);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('nome', $value->credor_devedor);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_saldo');
                } else {
                    if (isset($value->dia_receber) && $value->dia_receber > 0) {
                        $data_atual = $_POST['data1'];
                        $dia_atual = substr($_POST['data1'], 8);
                        $mes_atual = substr($_POST['data1'], 5, 2);
                        $ano_atual = substr($_POST['data1'], 0, 4);

                        if ($dia_atual < $value->dia_receber) {
                            $data_receber = $ano_atual . '-' . $mes_atual . '-' . $value->dia_receber;
                        } else {
                            $data_passada = $ano_atual . '-' . $mes_atual . '-' . $value->dia_receber;
                            $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_passada)));
                        }

                        $valor_n_parcelado = $valor_total;
                        $agenda_exames_id = $this->relatoriocaixapersonalizadoforma($value->forma_pagamento_id);
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

                            if ($parcelas != '') {
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

//                                if ($parcelas > 1) {
                            for ($i = 1; $i <= $parcelas; $i++) {
                                $tempo_receber = $tempo_receber + $value->tempo_receber;
                                $data_atual = $_POST['data1'];

                                if ($i == 1) {
                                    $data_receber_p = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_atual)));
                                }

                                $this->db->set('valor', $valor_parcelado);
                                $this->db->set('devedor', $value->credor_devedor);
                                $this->db->set('parcela', $i);

                                $proximoDiaUtil = $this->retornaProximoDiaUtil(strtotime($data_receber_p));

                                $this->db->set('data', $proximoDiaUtil);
//                                $this->db->set('data', $data_receber_p);
                                $this->db->set('classe', $classe);
                                $this->db->set('conta', $value->conta_id);
                                $this->db->set('observacao', $observacao);
                                $this->db->set('data_cadastro', $horario);
                                $this->db->set('operador_cadastro', $operador_id);
                                $this->db->insert('tb_financeiro_contasreceber_temp');

                                $data_receber_p = date("Y-m-d", strtotime("+$tempo_receber days", strtotime($data_atual)));
                            }
                            $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
                        }


                        $receber_temp = $this->burcarcontasrecebertemp();
                        foreach ($receber_temp as $temp) {
                            $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
                            $this->db->set('valor', $receber_temp2[0]->valor);
                            $this->db->set('devedor', $receber_temp2[0]->devedor);
                            $this->db->set('data', $temp->data);
                            $this->db->set('parcela', $receber_temp2[0]->parcela);
                            $this->db->set('numero_parcela', $parcelas);
                            $this->db->set('classe', $receber_temp2[0]->classe);
                            $this->db->set('conta', $receber_temp2[0]->conta);
                            $this->db->set('observacao', $receber_temp2[0]->observacao);
                            $this->db->set('empresa_id', $empresa_id);
                            $this->db->set('data_cadastro', $receber_temp2[0]->data_cadastro);
                            $this->db->set('operador_cadastro', $receber_temp2[0]->operador_cadastro);
                            $this->db->insert('tb_financeiro_contasreceber');
                        }
                        $this->db->set('ativo', 'f');
                        $this->db->update('tb_financeiro_contasreceber_temp');
                    } else {
                        if (isset($value->tempo_receber) && $value->tempo_receber > 0) {
                            $valor_n_parcelado = $valor_total;
                            $agenda_exames_id = $this->relatoriocaixapersonalizadoforma($value->forma_pagamento_id);

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

                                if ($parcelas != '') {
                                    $jurosporparcelas = $this->jurosporparcelas($value->forma_pagamento_id, $parcelas);
//                                    var_dump($parcelas); die;
                                    if ($jurosporparcelas[0]->taxa_juros > 0) {
                                        $taxa_juros = $jurosporparcelas[0]->taxa_juros;
                                    } else {
                                        $taxa_juros = 0;
                                    }
                                    $taxa_parcela = $valor * ($taxa_juros / 100);
                                    $valor_com_juros = $valor - $taxa_parcela;
                                    $valor_parcelado = $valor_com_juros / $parcelas;
                                } else {
                                    $valor_parcelado = $valor;
                                }

                                $tempo_receber = $value->tempo_receber;

                                for ($i = 1; $i <= $parcelas; $i++) {

                                    $tempo_receber = $tempo_receber + $value->tempo_receber;
                                    $data_atual = $_POST['data1'];

                                    if ($i == 1) {
                                        $data_receber_p = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_atual)));
                                    }

                                    $this->db->set('valor', $valor_parcelado);
                                    $this->db->set('devedor', $value->credor_devedor);
                                    $this->db->set('parcela', $i);

                                    $proximoDiaUtil = $this->retornaProximoDiaUtil(strtotime($data_receber_p));

                                    $this->db->set('data', $proximoDiaUtil);
                                    $this->db->set('classe', $classe);
                                    $this->db->set('conta', $value->conta_id);
                                    $this->db->set('observacao', $observacao);
                                    $this->db->set('data_cadastro', $horario);
                                    $this->db->set('operador_cadastro', $operador_id);
                                    $this->db->insert('tb_financeiro_contasreceber_temp');

                                    $data_receber_p = date("Y-m-d", strtotime("+$tempo_receber days", strtotime($data_atual)));
                                }
                                $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
                            }


                            $receber_temp = $this->burcarcontasrecebertemp();
                            foreach ($receber_temp as $temp) {
                                $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
                                $this->db->set('valor', $receber_temp2[0]->valor);
                                $this->db->set('devedor', $receber_temp2[0]->devedor);
                                $this->db->set('data', $temp->data);
                                $this->db->set('parcela', $receber_temp2[0]->parcela);
                                $this->db->set('numero_parcela', $parcelas);
                                $this->db->set('classe', $receber_temp2[0]->classe);
                                $this->db->set('conta', $receber_temp2[0]->conta);
                                $this->db->set('empresa_id', $empresa_id);
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
        }

        // Update na tabela agenda exames
        $procedimentos = substr($_POST['agenda_exames_id'], 0, (strlen($_POST['agenda_exames_id']) - 1));
        $sql = "UPDATE ponto.tb_agenda_exames
            SET operador_financeiro = $operador_id, data_financeiro= '$horario', financeiro = 't'
            WHERE agenda_exames_id in (
                {$procedimentos}
            )";
        $this->db->query($sql);
    }

    function retornaProximoDiaUtil($data) {
        $feriados = array();
        $result = $this->db->select("data")->from("tb_feriado")->where("ativo", 't')->get()->result();
        foreach ($result as $item) {
            $feriados[] = $item->data;
        }

        if (in_array(date("d/m", $data), $feriados) || date("N", $data) > 5) {
            $diaSeguinte = strtotime("+1 day", $data);
            return $this->retornaProximoDiaUtil($diaSeguinte);
        } else {
            return date("Y-m-d", $data);
        }
    }

    function fecharcaixapersonalizadocredito() {
//        die($_POST['empresa']);
//        try {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $empresa_id = $_POST['empresa'];
//        var_dump($empresa_id); die;
        $operador_id = $this->session->userdata('operador_id');
        $data_cauculo = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data1'])));
        $data_inicio = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data1'])));
        $data_fim = $_POST['data2'];
        $data_inicio_string = date("d/m/Y", strtotime(str_replace("/", "-", $_POST['data1'])));
        $data_fim_string = date("d/m/Y", strtotime(str_replace("/", "-", $_POST['data2'])));
        $observacao = "Credito* -- Periodo de " . $data_inicio_string . " a " . $data_fim_string;
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
        $this->db->where("forma_pagamento_id !=", '1000'); // Forma de pagamento CREDITO não pode ser levada em conta
//        $this->db->where("forma_pagamento_id IN (1,2,3)"); // Forma de pagamento CREDITO não pode ser levada em conta
//        $this->db->orderby("nome");
        $return = $this->db->get();

        $forma_pagamento = $return->result();
//        echo '<pre>';        
//        var_dump($forma_pagamento); die;

        $valor_total = '0.00';

        $teste = $_POST['qtdecredito'];
        foreach ($forma_pagamento as $value) {

            $classe = "CAIXA" . " " . $value->nome;

            foreach ($teste as $j => $t) {
                //Por limitacoes do CodeIgniter, tem que fazer isso.
                $j = strtolower(str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' '), '', $j));
                if ($j == strtolower(str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' '), '', $value->nome))) {
                    $valor_total = (str_replace(".", "", $t));
                    $valor_total = (str_replace(",", ".", $valor_total));
                }
            }
//            var_dump($valor_total); die;

            if ($valor_total != '0.00') {

                if ($value->nome == '' || $value->conta_id == '' || $value->credor_devedor == '' || $value->parcelas == '') {
                    return 10;
                }
                // Caso for dinheiro
                if ((!isset($value->tempo_receber) || $value->tempo_receber == 0) && (!isset($value->dia_receber) || $value->dia_receber == 0)) {

                    $this->db->set('data', $data_inicio);
                    $this->db->set('valor', $valor_total);
                    $this->db->set('classe', $classe);
                    $this->db->set('nome', $value->credor_devedor);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('observacao', $observacao);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_entradas');
                    $entradas_id = $this->db->insert_id();

                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('valor', $valor_total);
                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('entrada_id', $entradas_id);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('nome', $value->credor_devedor);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_saldo');
                } else {


//                    echo $classe, ' => ';
                    // Primeiro caso de Cartão
                    if (isset($value->dia_receber) && $value->dia_receber > 0) {
                        $data_atual = $_POST['data1'];
                        $dia_atual = substr($_POST['data1'], 8);
                        $mes_atual = substr($_POST['data1'], 5, 2);
                        $ano_atual = substr($_POST['data1'], 0, 4);
                        // Vai definir a data a ser gravada. Caso o dia atual seja menor que o dia cadastrado na forma. Ele coloca pro mês seguinte
                        if ($dia_atual < $value->dia_receber) {
                            $data_receber = $ano_atual . '-' . $mes_atual . '-' . $value->dia_receber;
                        } else {
                            $data_passada = $ano_atual . '-' . $mes_atual . '-' . $value->dia_receber;
                            $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_passada)));
                        }

                        $valor_n_parcelado = $valor_total;
                        $agenda_exames_id = $this->relatoriocaixaformacredito($value->forma_pagamento_id);
//                        echo '<pre>';
//                        var_dump($agenda_exames_id); die;
                        // Pega o valor da agenda exames com essa forma de pagamento
                        foreach ($agenda_exames_id as $item) {
                            // A partir daqui vai rodar um foreach com os pagamentos no relatório de caixa e verificar as parcelas de cada um
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
                            // Depois de definir o numero de Parcelas do cartão ele vai verificar se a quantidade de parcelas é diferente de nada pra poder colocar juros
                            // por parcela
                            if ($parcelas != '') {
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

//                                if ($parcelas > 1) {
                            // Agora ele grava na contasreceber temp as parcelas do cartão
                            for ($i = 1; $i <= $parcelas; $i++) {
                                $tempo_receber = $tempo_receber + $value->tempo_receber;
                                $data_atual = $_POST['data1'];

                                if ($i == 1) {
                                    $data_receber_p = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_atual)));
                                }

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

                                $data_receber_p = date("Y-m-d", strtotime("+$tempo_receber days", strtotime($data_atual)));
                            }
                            $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
                        }


                        $receber_temp = $this->burcarcontasrecebertemp();
                        foreach ($receber_temp as $temp) {
                            $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
                            $this->db->set('valor', $receber_temp2[0]->valor);
                            $this->db->set('devedor', $receber_temp2[0]->devedor);
                            $this->db->set('data', $temp->data);
                            $this->db->set('parcela', $receber_temp2[0]->parcela);
                            $this->db->set('numero_parcela', $parcelas);
                            $this->db->set('classe', $receber_temp2[0]->classe);
                            $this->db->set('conta', $receber_temp2[0]->conta);
                            $this->db->set('observacao', $receber_temp2[0]->observacao);
                            $this->db->set('data_cadastro', $receber_temp2[0]->data_cadastro);
                            $this->db->set('operador_cadastro', $receber_temp2[0]->operador_cadastro);
                            $this->db->set('empresa_id', $empresa_id);
//                            var_dump($empresa_id); die;
                            $this->db->insert('tb_financeiro_contasreceber');
                        }
                        $this->db->set('ativo', 'f');
                        $this->db->update('tb_financeiro_contasreceber_temp');
                    } else {
                        if (isset($value->tempo_receber) && $value->tempo_receber > 0) {

                            $valor_n_parcelado = $valor_total;
                            $agenda_exames_id = $this->relatoriocaixaformacredito($value->forma_pagamento_id);
//                            echo '<pre>';
//                            var_dump($agenda_exames_id); die;
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

                                if ($parcelas != '') {
                                    $jurosporparcelas = $this->jurosporparcelas($value->forma_pagamento_id, $parcelas);
//                                    var_dump($jurosporparcelas); die;
                                    if (@$jurosporparcelas[0]->taxa_juros > 0) {
                                        $taxa_juros = $jurosporparcelas[0]->taxa_juros;
                                    } else {
                                        $taxa_juros = 0;
                                    }
                                    $taxa_parcela = $valor * ($taxa_juros / 100);
                                    $valor_com_juros = $valor - $taxa_parcela;
                                    $valor_parcelado = $valor_com_juros / $parcelas;
                                } else {
                                    $valor_parcelado = $valor;
                                }

                                $tempo_receber = $value->tempo_receber;
//                                if ($parcelas > 1) {
                                for ($i = 1; $i <= $parcelas; $i++) {

                                    $tempo_receber = $tempo_receber + $value->tempo_receber;
                                    $data_atual = $_POST['data1'];

                                    if ($i == 1) {
                                        $data_receber_p = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_atual)));
                                    }

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

                                    $data_receber_p = date("Y-m-d", strtotime("+$tempo_receber days", strtotime($data_atual)));
                                }
                                $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
                            }

                            $receber_temp = $this->burcarcontasrecebertemp();

                            foreach ($receber_temp as $temp) {
                                $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
                                $this->db->set('valor', $receber_temp2[0]->valor);
                                $this->db->set('devedor', $receber_temp2[0]->devedor);
                                $this->db->set('data', $temp->data);
                                $this->db->set('parcela', $receber_temp2[0]->parcela);
                                $this->db->set('numero_parcela', $parcelas);
                                $this->db->set('classe', $receber_temp2[0]->classe);
                                $this->db->set('conta', $receber_temp2[0]->conta);
                                $this->db->set('observacao', $receber_temp2[0]->observacao);
                                $this->db->set('data_cadastro', $receber_temp2[0]->data_cadastro);
                                $this->db->set('empresa_id', $empresa_id);
//                                                            var_dump($empresa_id); die;
                                $this->db->set('operador_cadastro', $receber_temp2[0]->operador_cadastro);
                                $this->db->insert('tb_financeiro_contasreceber');
                            }
//                            
                            $this->db->set('ativo', 'f');
                            $this->db->update('tb_financeiro_contasreceber_temp');
                        }
                    }
                }
            }
        }
    }

    function fecharcaixamodelo2() {
//        echo '<pre>';
//        var_dump($_POST); 
//        die;
//        die($_POST['empresa']);
//        try {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $empresaAtual = $this->session->userdata('empresa_id');
        $operadorAtual = $this->session->userdata('operador_id');
        $empresa_id = $_POST['empresa'];
        $operador_id = $_POST['operador'];
        $medico_id = $_POST['medico'];
        if ($empresa_id > 0) {
            $empresa_obs = " Empresa: {$_POST['empresaNome']}";
        } else {
//            $empresa_id = $empresaAtual;
            $empresa_obs = " Todas as Empresas";
        }
        if ($operador_id > 0) {
            $operador_obs = " Operador: {$_POST['operadorNome']}";
        } else {
            $operador_obs = " ";
        }
        // Nao funcionando ainda a parte do médico
        if ($medico_id > 0) {
            $medico_obs = " Médico: {$_POST['medicoNome']}";
        } else {
            $medico_obs = " ";
        }



//        var_dump($empresa_id); die;

        $dataAtual = date("Y-m-d");
        $data_inicio = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data1'])));
        $data_fim = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data2'])));
        $data_inicio_obs = date("d/m/Y", strtotime(str_replace("/", "-", $data_inicio)));
        $data_fim_obs = date("d/m/Y", strtotime(str_replace("/", "-", $data_fim)));


        $observacao = "Caixa Período: $data_inicio_obs até $data_fim_obs $empresa_obs $operador_obs";


        $this->db->select(' array_agg(aef.agenda_exames_faturar_id) as agenda_exames_array,
                            aef.forma_pagamento_id,
                            aef.parcela,
                            f.nome as forma_pagamento,
                            f.nome,
                            f.cartao,
                            f.credor_devedor,
                            f.tempo_receber, 
                            f.dia_receber,
                            f.parcelas,
                            sum(aef.valor) as valor_total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_agenda_exames_faturar aef', 'aef.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = aef.forma_pagamento_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador_grupo_medico ogm', 'ae.medico_consulta_id = ogm.operador_id', 'left');
//        $this->db->join('tb_operador_grupo og', 'og.operador_grupo_id = ogm.operador_grupo_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = aef.operador_cadastro', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.confirmado', 'true');
        $this->db->where('pt.home_care', 'f');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where('pt.grupo !=', 'CIRURGICO');
        $this->db->where('c.dinheiro', "t");
        // $this->db->where('(aef.ativo = true OR aef.ativo is null)');
        $this->db->where("aef.data >= '$data_inicio'");
        $this->db->where("aef.data <= '$data_fim'");
        $this->db->where('aef.financeiro', "f");

//        if ($_POST['medico'] != "0") {
//            $this->db->where('al.medico_parecer1', $_POST['medico']);
//        }
        if ($operador_id != "0") {
            $this->db->where('ae.operador_autorizacao', $operador_id);
        }
        if ($empresa_id != "0") {
            $this->db->where('ae.empresa_id', $empresa_id);
        }
        $this->db->groupby('
                            aef.forma_pagamento_id,
                            aef.parcela,
                            f.nome,
                            f.cartao,
                            f.credor_devedor,
                            f.tempo_receber, 
                            f.dia_receber,
                            f.parcelas,
                            ');
        $this->db->orderby('aef.forma_pagamento_id');
//        $this->db->orderby('pc.convenio_id');
        $return = $this->db->get()->result();

    //    echo '<pre>';
    //    var_dump($return);
    //    die;
        // Foreach só pra saber se todas as formas estão configuradas corretamente
        foreach ($return as $value) {
            // Precisa ter uma empresa associada a conta
            // No caso se for pra fechar de todas as empresas
            // ele vê se tem conta na empresa em que o operador tá logado
            // já que ele vai inserir lá
            $this->db->select('conta_id');
            $this->db->from('tb_formapagamento_conta_empresa');
            $this->db->where("ativo", 't');
            $this->db->where("forma_pagamento_id", $value->forma_pagamento_id);
            if ($empresa_id > 0) {
                $this->db->where("empresa_id", $empresa_id);
            } else {
                $this->db->where("empresa_id", $empresaAtual);
            }
            $conta_array = $this->db->get()->result();

//            var_dump($conta_array); die;
            if (count($conta_array) > 0) {
                $value->conta_id = $conta_array[0]->conta_id;
            } else {
                $value->conta_id = '';
            }
            // Precisa de credor, nome, conta e etc.
            if ($value->nome == '' || $value->conta_id == '' || $value->credor_devedor == '' || $value->parcelas == '') {
//                    echo 'ENTROU AQUI 1';
                return 10;
            }
            // Se tiver dia receber e tempo receber, ele não fecha o caixa
            // ou é um, ou é outro.
            if ($value->tempo_receber > 0 && $value->dia_receber > 0) {
//                 echo 'ENTROU AQUI 2';
                return 10;
            }
        }
//        die;
        // Inserindo nas tabelas
        // Parcelas ainda não estão caindo corretamente


        $i = 0;
        if ($empresa_id > 0) {
            $empresa_insert = $empresa_id;
        } else {
            $empresa_insert = $empresaAtual;
        }
        foreach ($return as $value) {
            // Inserindo na tabela nova de caixa
            $this->db->set('valor', $value->valor_total);
            $this->db->set('forma_pagamento_id', $value->forma_pagamento_id);
            $this->db->set('forma_pagamento_nome', $value->nome);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_financeiro_caixa');
            $financeiro_caixa_id = $this->db->insert_id();

            $classe = "CAIXA" . " " . $value->nome;
            $valor_total = $value->valor_total;
            if ($value->cartao == 'f') {

                // Se é dinheiro
                $this->db->set('financeiro_caixa_id', $financeiro_caixa_id);
                $this->db->set('data', $data_inicio);
                $this->db->set('valor', $valor_total);
                $this->db->set('classe', $classe);
                $this->db->set('nome', $value->credor_devedor);
                $this->db->set('conta', $value->conta_id);
                $this->db->set('observacao', $observacao);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('empresa_id', $empresa_insert);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_entradas');
                $entradas_id = $this->db->insert_id();

                $this->db->set('data', $data_inicio);
                $this->db->set('valor', $valor_total);
                $this->db->set('data', $data_inicio);
                $this->db->set('entrada_id', $entradas_id);
                $this->db->set('conta', $value->conta_id);
                $this->db->set('nome', $value->credor_devedor);
                $this->db->set('empresa_id', $empresa_insert);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_saldo');
            } else {
//                    $dataAtual = '';
                if ($value->tempo_receber > 0) {

                    $data_receber = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_inicio)));
                } elseif ($value->dia_receber > 0) {
                    $diaAtual = date("d", strtotime($data_inicio));
                    $mesAtual = date("m", strtotime($data_inicio));
                    $anoAtual = date("Y", strtotime($data_inicio));
                    $data_string = "$anoAtual-$mesAtual-{$value->dia_receber}";
                    $data_receber = date("Y-m-d", strtotime($data_string));

                    if ($diaAtual > $value->dia_receber) {
                        $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                    }
                } else {
                    $data_receber = $data_inicio;
                }
                $parcelas_pag = $value->parcela;

                $valor_parcela = $valor_total/$parcelas_pag;
                // Insert no contas a receber

                // Insert na tabela contas a receber Temp
                for($i = 1; $i <= $parcelas_pag; $i++){

                    // $this->db->set('financeiro_caixa_id', $financeiro_caixa_id);
                    $this->db->set('valor', $valor_parcela);
                    $this->db->set('devedor', $value->credor_devedor);
                    $this->db->set('data', $data_receber);
                    $this->db->set('parcela', $i);
                    $this->db->set('numero_parcela', $parcelas_pag);
                    $this->db->set('classe', $classe);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('observacao', $observacao);
                    $this->db->set('data_cadastro', $horario);
                    // $this->db->set('empresa_id', $empresa_insert);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_financeiro_contasreceber_temp');

                    $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_receber)));
                }

            }

            $array_agenda_examesPG = $value->agenda_exames_array;
            $array_agenda_examesStr = str_replace('{', '', str_replace('}', '', $array_agenda_examesPG));
            $array_agenda_exames = explode(',', $array_agenda_examesStr);
            // Dando update na tabela de pagamento.
            $this->db->set('financeiro', 't');
            $this->db->set('data_financeiro', $horario);
            $this->db->set('operador_financeiro', $operador_id);
            $this->db->where_in('agenda_exames_faturar_id', $array_agenda_exames);
            $this->db->update('tb_agenda_exames_faturar');
        }// Fim do foreach
        // Inserindo da temp pra Contas Receber
        $receber_temp = $this->burcarcontasreceberModelo2();
        // echo '<pre>';
        foreach ($receber_temp as $temp) {
            // var_dump($temp);
            // echo '<br> <hr><br>';
            $receber_temp2 = $this->buscarParcelaMaxima($temp->devedor);
            // var_dump($receber_temp2);
            // echo '<br> <hr><br>';
            // $this->db->set('financeiro_caixa_id', $temp->financeiro_caixa_id);
            $this->db->set('valor', $temp->valor);
            $this->db->set('devedor', $temp->devedor);
            $this->db->set('data', $temp->data);
            $this->db->set('parcela', $temp->parcela);
            $this->db->set('numero_parcela', $receber_temp2[0]->max);
            $this->db->set('classe', $temp->classe);
            $this->db->set('conta', $temp->conta);
            $this->db->set('observacao', $temp->observacao);
            $this->db->set('observacao', $observacao);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('empresa_id', $empresa_insert);
            $this->db->insert('tb_financeiro_contasreceber');

        }
        $this->db->set('ativo', 'f');
        $this->db->update('tb_financeiro_contasreceber_temp');
        // die;

        return 1;
//        echo '<pre>';
//        var_dump($return);
//        die;
    }

    function fecharcaixa() {
//        die($_POST['empresa']);
//        try {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $empresa_id = $_POST['empresa'];
//        var_dump($empresa_id); die;
        $operador_id = $this->session->userdata('operador_id');
        $data_cauculo = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data1'])));
        $data_inicio = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data1'])));
        $data_fim = $_POST['data2'];
        $observacao = "Periodo de " . $_POST['data1'] . " a " . $_POST['data2'];
        $data = date("Y-m-d");
        $data30 = date('Y-m-d', strtotime("+30 days", strtotime($data_cauculo)));
        $data4 = date('Y-m-d', strtotime("+4 days", strtotime($data_cauculo)));
        $data2 = date('Y-m-d', strtotime("+2 days", strtotime($data_cauculo)));

        $this->db->select('forma_pagamento_id,
                            nome, 
                            credor_devedor,
                            tempo_receber, 
                            dia_receber,
                            parcelas');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $this->db->where("forma_pagamento_id !=", '1000'); // Forma de pagamento CREDITO não pode ser levada em conta
//        $this->db->where("forma_pagamento_id IN (1,2,3)"); // Forma de pagamento CREDITO não pode ser levada em conta
//        $this->db->orderby("nome");
        $return = $this->db->get();

        $forma_pagamento = $return->result();
//        echo '<pre>';
//        var_dump($forma_pagamento);
//        die;

        $valor_total = '0.00';

        $teste = $_POST['qtde'];
        foreach ($forma_pagamento as $value) {
            // Selecionando a conta baseada na empresa

            $this->db->select('conta_id');
            $this->db->from('tb_formapagamento_conta_empresa');
            $this->db->where("ativo", 't');
            $this->db->where("forma_pagamento_id", $value->forma_pagamento_id);
            $this->db->where("empresa_id", $empresa_id);

            $conta_array = $this->db->get()->result();

//            var_dump($conta_array); die;
            if (count($conta_array) > 0) {
                $value->conta_id = $conta_array[0]->conta_id;
            } else {
                $value->conta_id = '';
            }
//            var_dump($value->conta_id); die;
            $classe = "CAIXA" . " " . $value->nome;

            foreach ($teste as $j => $t) {
                //Por limitacoes do CodeIgniter, tem que fazer isso.
                $j = strtolower(str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' '), '', $j));
                if ($j == strtolower(str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' '), '', $value->nome))) {
                    $valor_total = (str_replace(".", "", $t));
                    $valor_total = (str_replace(",", ".", $valor_total));
                }
            }
//            var_dump($valor_total); die;

            if ($valor_total != '0.00') {

                if ($value->nome == '' || $value->conta_id == '' || $value->credor_devedor == '' || $value->parcelas == '') {
                    return 10;
                }
                // Caso for dinheiro
                if ((!isset($value->tempo_receber) || $value->tempo_receber == 0) && (!isset($value->dia_receber) || $value->dia_receber == 0)) {

                    $this->db->set('data', $data_inicio);
                    $this->db->set('valor', $valor_total);
                    $this->db->set('classe', $classe);
                    $this->db->set('nome', $value->credor_devedor);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('observacao', $observacao);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_entradas');
                    $entradas_id = $this->db->insert_id();

                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('valor', $valor_total);
                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('entrada_id', $entradas_id);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('nome', $value->credor_devedor);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_saldo');
                } else {


//                    echo $classe, ' => ';
                    // Primeiro caso de Cartão
                    if (isset($value->dia_receber) && $value->dia_receber > 0) {
                        $data_atual = $_POST['data1'];
                        $dia_atual = substr($_POST['data1'], 8);
                        $mes_atual = substr($_POST['data1'], 5, 2);
                        $ano_atual = substr($_POST['data1'], 0, 4);
                        // Vai definir a data a ser gravada. Caso o dia atual seja menor que o dia cadastrado na forma. Ele coloca pro mês seguinte
                        if ($dia_atual < $value->dia_receber) {
                            $data_receber = $ano_atual . '-' . $mes_atual . '-' . $value->dia_receber;
                        } else {
                            $data_passada = $ano_atual . '-' . $mes_atual . '-' . $value->dia_receber;
                            $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_passada)));
                        }

                        $valor_n_parcelado = $valor_total;
                        $agenda_exames_id = $this->relatoriocaixaforma($value->forma_pagamento_id);
                        // Pega o valor da agenda exames com essa forma de pagamento
                        foreach ($agenda_exames_id as $item) {
                            // A partir daqui vai rodar um foreach com os pagamentos no relatório de caixa e verificar as parcelas de cada um
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
                            // Depois de definir o numero de Parcelas do cartão ele vai verificar se a quantidade de parcelas é diferente de nada pra poder colocar juros
                            // por parcela
                            if ($parcelas != '') {
                                $jurosporparcelas = $this->jurosporparcelas($value->forma_pagamento_id, $parcelas);
//                                echo '1';
//                                var_dump($jurosporparcelas); die;
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

//                                if ($parcelas > 1) {
                            // Agora ele grava na contasreceber temp as parcelas do cartão
                            for ($i = 1; $i <= $parcelas; $i++) {
                                $tempo_receber = $tempo_receber + $value->tempo_receber;
                                $data_atual = $_POST['data1'];

                                if ($i == 1) {
                                    $data_receber_p = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_atual)));
                                }

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

                                $data_receber_p = date("Y-m-d", strtotime("+$tempo_receber days", strtotime($data_atual)));
                            }
                            $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
                        }


                        $receber_temp = $this->burcarcontasrecebertemp();
                        foreach ($receber_temp as $temp) {
                            $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
                            $this->db->set('valor', $receber_temp2[0]->valor);
                            $this->db->set('devedor', $receber_temp2[0]->devedor);
                            $this->db->set('data', $temp->data);
                            $this->db->set('parcela', $receber_temp2[0]->parcela);
                            $this->db->set('numero_parcela', $parcelas);
                            $this->db->set('classe', $receber_temp2[0]->classe);
                            $this->db->set('conta', $receber_temp2[0]->conta);
                            $this->db->set('observacao', $receber_temp2[0]->observacao);
                            $this->db->set('data_cadastro', $receber_temp2[0]->data_cadastro);
                            $this->db->set('operador_cadastro', $receber_temp2[0]->operador_cadastro);
                            $this->db->set('empresa_id', $empresa_id);
//                            var_dump($empresa_id); die;
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

                                if ($parcelas != '') {
                                    $jurosporparcelas = $this->jurosporparcelas($value->forma_pagamento_id, $parcelas);
//                                    echo '2';

                                    if (@$jurosporparcelas[0]->taxa_juros > 0) {
                                        $taxa_juros = $jurosporparcelas[0]->taxa_juros;
                                    } else {
                                        $taxa_juros = 0;
                                    }
                                    $taxa_parcela = $valor * ($taxa_juros / 100);
                                    $valor_com_juros = $valor - $taxa_parcela;
                                    $valor_parcelado = $valor_com_juros / $parcelas;
                                } else {
                                    $valor_parcelado = $valor;
                                }
//                                 var_dump($valor); die;

                                $tempo_receber = $value->tempo_receber;
//                                if ($parcelas > 1) {
                                for ($i = 1; $i <= $parcelas; $i++) {

                                    $tempo_receber = $tempo_receber + $value->tempo_receber;
                                    $data_atual = $_POST['data1'];

                                    if ($i == 1) {
                                        $data_receber_p = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_atual)));
                                    }

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

                                    $data_receber_p = date("Y-m-d", strtotime("+$tempo_receber days", strtotime($data_atual)));
                                }
                                $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
                            }

                            $receber_temp = $this->burcarcontasrecebertemp();

                            foreach ($receber_temp as $temp) {
                                $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
                                $this->db->set('valor', $receber_temp2[0]->valor);
                                $this->db->set('devedor', $receber_temp2[0]->devedor);
                                $this->db->set('data', $temp->data);
                                $this->db->set('parcela', $receber_temp2[0]->parcela);
                                $this->db->set('numero_parcela', $parcelas);
                                $this->db->set('classe', $receber_temp2[0]->classe);
                                $this->db->set('conta', $receber_temp2[0]->conta);
                                $this->db->set('observacao', $receber_temp2[0]->observacao);
                                $this->db->set('data_cadastro', $receber_temp2[0]->data_cadastro);
                                $this->db->set('empresa_id', $empresa_id);
//                                                            var_dump($empresa_id); die;
                                $this->db->set('operador_cadastro', $receber_temp2[0]->operador_cadastro);
                                $this->db->insert('tb_financeiro_contasreceber');
                            }

                            $this->db->set('ativo', 'f');
                            $this->db->update('tb_financeiro_contasreceber_temp');
                        }
                    }
                }
            }
        }



        $empresa = (isset($_POST['empresa']) ? ' AND ae.empresa_id = ' . $_POST['empresa'] : '');

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
$empresa
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
$empresa
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
$empresa
AND c.dinheiro = true  
ORDER BY ae.agenda_exames_id)";
            $this->db->query($sql);
        }
    }

    function fecharcaixacredito() {
//        die($_POST['empresa']);
//        try {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $empresa_id = $_POST['empresa'];
//        var_dump($empresa_id); die;
        $operador_id = $this->session->userdata('operador_id');
        $data_cauculo = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data1'])));
        $data_inicio = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data1'])));
        $data_fim = $_POST['data2'];
        $data_inicio_string = date("d/m/Y", strtotime(str_replace("/", "-", $_POST['data1'])));
        $data_fim_string = date("d/m/Y", strtotime(str_replace("/", "-", $_POST['data2'])));
        $observacao = "Credito* -- Periodo de " . $data_inicio_string . " a " . $data_fim_string;
        $data = date("Y-m-d");
        $data30 = date('Y-m-d', strtotime("+30 days", strtotime($data_cauculo)));
        $data4 = date('Y-m-d', strtotime("+4 days", strtotime($data_cauculo)));
        $data2 = date('Y-m-d', strtotime("+2 days", strtotime($data_cauculo)));

        $this->db->select('forma_pagamento_id,
                            nome, 
                            credor_devedor,
                            tempo_receber, 
                            dia_receber,
                            parcelas');
        $this->db->from('tb_forma_pagamento');
        $this->db->where("ativo", 't');
        $this->db->where("forma_pagamento_id !=", '1000'); // Forma de pagamento CREDITO não pode ser levada em conta
//        $this->db->where("forma_pagamento_id IN (1,2,3)"); // Forma de pagamento CREDITO não pode ser levada em conta
//        $this->db->orderby("nome");
        $return = $this->db->get();

        $forma_pagamento = $return->result();
//        echo '<pre>';        
//        var_dump($forma_pagamento); die;

        $valor_total = '0.00';

        $teste = $_POST['qtdecredito'];
        foreach ($forma_pagamento as $value) {
            // Selecionando a conta baseada na empresa

            $this->db->select('conta_id');
            $this->db->from('tb_formapagamento_conta_empresa');
            $this->db->where("ativo", 't');
            $this->db->where("forma_pagamento_id", $value->forma_pagamento_id);
            $this->db->where("empresa_id", $empresa_id);

            $conta_array = $this->db->get()->result();

//            var_dump($conta_array); die;
            if (count($conta_array) > 0) {
                $value->conta_id = $conta_array[0]->conta_id;
            } else {
                $value->conta_id = '';
            }
//            var_dump($value->conta_id); die;

            $classe = "CAIXA" . " " . $value->nome;

            foreach ($teste as $j => $t) {
                //Por limitacoes do CodeIgniter, tem que fazer isso.
                $j = strtolower(str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' '), '', $j));
                if ($j == strtolower(str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', ' '), '', $value->nome))) {
                    $valor_total = (str_replace(".", "", $t));
                    $valor_total = (str_replace(",", ".", $valor_total));
                }
            }
//            var_dump($valor_total); die;

            if ($valor_total != '0.00') {

                if ($value->nome == '' || $value->conta_id == '' || $value->credor_devedor == '' || $value->parcelas == '') {
                    return 10;
                }
                // Caso for dinheiro
                if ((!isset($value->tempo_receber) || $value->tempo_receber == 0) && (!isset($value->dia_receber) || $value->dia_receber == 0)) {

                    $this->db->set('data', $data_inicio);
                    $this->db->set('valor', $valor_total);
                    $this->db->set('classe', $classe);
                    $this->db->set('nome', $value->credor_devedor);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('observacao', $observacao);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_entradas');
                    $entradas_id = $this->db->insert_id();

                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('valor', $valor_total);
                    $this->db->set('data', $_POST['data1']);
                    $this->db->set('entrada_id', $entradas_id);
                    $this->db->set('conta', $value->conta_id);
                    $this->db->set('nome', $value->credor_devedor);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_saldo');
                } else {


//                    echo $classe, ' => ';
                    // Primeiro caso de Cartão
                    if (isset($value->dia_receber) && $value->dia_receber > 0) {
                        $data_atual = $_POST['data1'];
                        $dia_atual = substr($_POST['data1'], 8);
                        $mes_atual = substr($_POST['data1'], 5, 2);
                        $ano_atual = substr($_POST['data1'], 0, 4);
                        // Vai definir a data a ser gravada. Caso o dia atual seja menor que o dia cadastrado na forma. Ele coloca pro mês seguinte
                        if ($dia_atual < $value->dia_receber) {
                            $data_receber = $ano_atual . '-' . $mes_atual . '-' . $value->dia_receber;
                        } else {
                            $data_passada = $ano_atual . '-' . $mes_atual . '-' . $value->dia_receber;
                            $data_receber = date("Y-m-d", strtotime("+1 month", strtotime($data_passada)));
                        }

                        $valor_n_parcelado = $valor_total;
                        $agenda_exames_id = $this->relatoriocaixaformacredito($value->forma_pagamento_id);
//                        echo '<pre>';
//                        var_dump($agenda_exames_id); die;
                        // Pega o valor da agenda exames com essa forma de pagamento
                        foreach ($agenda_exames_id as $item) {
                            // A partir daqui vai rodar um foreach com os pagamentos no relatório de caixa e verificar as parcelas de cada um
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
                            // Depois de definir o numero de Parcelas do cartão ele vai verificar se a quantidade de parcelas é diferente de nada pra poder colocar juros
                            // por parcela
                            if ($parcelas != '') {
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

//                                if ($parcelas > 1) {
                            // Agora ele grava na contasreceber temp as parcelas do cartão
                            for ($i = 1; $i <= $parcelas; $i++) {
                                $tempo_receber = $tempo_receber + $value->tempo_receber;
                                $data_atual = $_POST['data1'];

                                if ($i == 1) {
                                    $data_receber_p = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_atual)));
                                }

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

                                $data_receber_p = date("Y-m-d", strtotime("+$tempo_receber days", strtotime($data_atual)));
                            }
                            $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
                        }


                        $receber_temp = $this->burcarcontasrecebertemp();
                        foreach ($receber_temp as $temp) {
                            $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
                            $this->db->set('valor', $receber_temp2[0]->valor);
                            $this->db->set('devedor', $receber_temp2[0]->devedor);
                            $this->db->set('data', $temp->data);
                            $this->db->set('parcela', $receber_temp2[0]->parcela);
                            $this->db->set('numero_parcela', $parcelas);
                            $this->db->set('classe', $receber_temp2[0]->classe);
                            $this->db->set('conta', $receber_temp2[0]->conta);
                            $this->db->set('observacao', $receber_temp2[0]->observacao);
                            $this->db->set('data_cadastro', $receber_temp2[0]->data_cadastro);
                            $this->db->set('operador_cadastro', $receber_temp2[0]->operador_cadastro);
                            $this->db->set('empresa_id', $empresa_id);
//                            var_dump($empresa_id); die;
                            $this->db->insert('tb_financeiro_contasreceber');
                        }
                        $this->db->set('ativo', 'f');
                        $this->db->update('tb_financeiro_contasreceber_temp');
                    } else {
                        if (isset($value->tempo_receber) && $value->tempo_receber > 0) {

                            $valor_n_parcelado = $valor_total;
                            $agenda_exames_id = $this->relatoriocaixaformacredito($value->forma_pagamento_id);
//                            echo '<pre>';
//                            var_dump($agenda_exames_id); die;
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

                                if ($parcelas != '') {
                                    $jurosporparcelas = $this->jurosporparcelas($value->forma_pagamento_id, $parcelas);
//                                    var_dump($jurosporparcelas); die;
                                    if (@$jurosporparcelas[0]->taxa_juros > 0) {
                                        $taxa_juros = $jurosporparcelas[0]->taxa_juros;
                                    } else {
                                        $taxa_juros = 0;
                                    }
                                    $taxa_parcela = $valor * ($taxa_juros / 100);
                                    $valor_com_juros = $valor - $taxa_parcela;
                                    $valor_parcelado = $valor_com_juros / $parcelas;
                                } else {
                                    $valor_parcelado = $valor;
                                }

                                $tempo_receber = $value->tempo_receber;
//                                if ($parcelas > 1) {
                                for ($i = 1; $i <= $parcelas; $i++) {

                                    $tempo_receber = $tempo_receber + $value->tempo_receber;
                                    $data_atual = $_POST['data1'];

                                    if ($i == 1) {
                                        $data_receber_p = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_atual)));
                                    }

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

                                    $data_receber_p = date("Y-m-d", strtotime("+$tempo_receber days", strtotime($data_atual)));
                                }
                                $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
                            }

                            $receber_temp = $this->burcarcontasrecebertemp();

                            foreach ($receber_temp as $temp) {
                                $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
                                $this->db->set('valor', $receber_temp2[0]->valor);
                                $this->db->set('devedor', $receber_temp2[0]->devedor);
                                $this->db->set('data', $temp->data);
                                $this->db->set('parcela', $receber_temp2[0]->parcela);
                                $this->db->set('numero_parcela', $parcelas);
                                $this->db->set('classe', $receber_temp2[0]->classe);
                                $this->db->set('conta', $receber_temp2[0]->conta);
                                $this->db->set('observacao', $receber_temp2[0]->observacao);
                                $this->db->set('data_cadastro', $receber_temp2[0]->data_cadastro);
                                $this->db->set('empresa_id', $empresa_id);
//                                                            var_dump($empresa_id); die;
                                $this->db->set('operador_cadastro', $receber_temp2[0]->operador_cadastro);
                                $this->db->insert('tb_financeiro_contasreceber');
                            }
//                            
                            $this->db->set('ativo', 'f');
                            $this->db->update('tb_financeiro_contasreceber_temp');
                        }
                    }
                }
            }
        }

        $empresa = (isset($_POST['empresa']) ? ' AND ae.empresa_id = ' . $_POST['empresa'] : '');
        $sql = "UPDATE ponto.tb_paciente_credito
SET operador_financeiro = $operador_id, data_financeiro= '$horario', financeiro_fechado = 't'
where paciente_credito_id in (SELECT ae.paciente_credito_id
FROM ponto.tb_paciente_credito ae 
WHERE ae.ativo = true 
AND ae.data >= '$data_inicio' 
AND ae.data <= '$data_fim' 
$empresa
ORDER BY ae.paciente_credito_id)";
        $this->db->query($sql);
    }

    function jurosporparcelas($formapagamento_id, $parcelas) {
        $this->db->select('taxa_juros');
        $this->db->from('tb_formapagamento_pacela_juros');
        $this->db->where('forma_pagamento_id', $formapagamento_id);
        $this->db->where('parcelas_inicio <=', $parcelas);
        $this->db->where('parcelas_fim >=', $parcelas);
        $this->db->where('ativo', 't');
        $query = $this->db->get();

        return $query->result();
    }

    function fecharpromotor() {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

//        if ($this->session->userdata('producao_medica_saida') != 't') {
        if ($data_contaspagar == 't') {
            $this->db->set('data', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_escolhida']))));
        } else {
            $this->db->set('data', $data);
        }

        $this->db->set('valor', $_POST['valor']);
        $this->db->set('tipo', $_POST['tipo']);
        $this->db->set('credor', $_POST['nome']);
        $this->db->set('conta', $_POST['conta']);
        $this->db->set('classe', $_POST['classe']);
        $this->db->set('observacao', $_POST['observacao']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_financeiro_contaspagar');
//        } else {
//            if ($data_contaspagar == 't') {
//                $this->db->set('data', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_escolhida']))));
//            } else {
//                $this->db->set('data', $data);
//            }
//
//            $this->db->set('valor', $_POST['valor']);
//            $this->db->set('tipo', $_POST['tipo']);
//            $this->db->set('nome', $_POST['nome']);
//            $this->db->set('conta', $_POST['conta']);
//            $this->db->set('classe', $_POST['classe']);
//            $this->db->set('observacao', $_POST['observacao']);
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('empresa_id', $empresa_id);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_saidas');
//            $saida_id = $this->db->insert_id();
//
//            $this->db->set('valor', -$_POST['valor']);
//            $this->db->set('conta', $_POST['conta']);
//            $this->db->set('nome', $_POST['valor']);
//            $this->db->set('saida_id', $saida_id);
//            $this->db->set('empresa_id', $empresa_id);
//            $this->db->set('data_cadastro', $horario);
//            if ($data_contaspagar == 't') {
//                $this->db->set('data', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_escolhida']))));
//            } else {
//                $this->db->set('data', $data);
//            }
//            $this->db->set('empresa_id', $empresa_id);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_saldo');
//        }
    }

    function fecharmedico($data_contaspagar) {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        if ($this->session->userdata('producao_medica_saida') != 't') {
            if ($data_contaspagar == 't') {
                $this->db->set('data', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_escolhida']))));
            } else {
                $this->db->set('data', $data);
            }

            $this->db->set('valor', $_POST['valor']);
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('credor', $_POST['nome']);
            $this->db->set('conta', $_POST['conta']);
            $this->db->set('classe', $_POST['classe']);
            $this->db->set('observacao', $_POST['observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_financeiro_contaspagar');
        } else {
            if ($data_contaspagar == 't') {
                $this->db->set('data', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_escolhida']))));
            } else {
                $this->db->set('data', $data);
            }

            $this->db->set('valor', $_POST['valor']);
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('nome', $_POST['nome']);
            $this->db->set('conta', $_POST['conta']);
            $this->db->set('classe', $_POST['classe']);
            $this->db->set('observacao', $_POST['observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saidas');
            $saida_id = $this->db->insert_id();

            $this->db->set('valor', -$_POST['valor']);
            $this->db->set('conta', $_POST['conta']);
            $this->db->set('nome', $_POST['valor']);
            $this->db->set('saida_id', $saida_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            if ($data_contaspagar == 't') {
                $this->db->set('data', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_escolhida']))));
            } else {
                $this->db->set('data', $data);
            }
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saldo');
        }


        $empresa = ($_POST['empresa'] > 0 ? ' AND ae.empresa_id = ' . $_POST['empresa'] : '');

        $data_inicio = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data'])));
        $data_fim = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_fim'])));
        $medico_id = $_POST['operador_id'];
        $sql = "UPDATE ponto.tb_agenda_exames
                SET operador_producao = $operador_id, data_producao = '$horario', producao_paga = 't'
                where agenda_exames_id in (SELECT ae.agenda_exames_id
                FROM ponto.tb_agenda_exames ae 
                LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id 
                LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id 
                LEFT JOIN ponto.tb_exames e ON e.agenda_exames_id = ae.agenda_exames_id 
                LEFT JOIN ponto.tb_ambulatorio_laudo al ON al.exame_id = e.exames_id 
                LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id 
                WHERE e.cancelada = 'false' 
                AND al.data_producao >= '$data_inicio' 
                AND al.data_producao <= '$data_fim' 
                AND al.medico_parecer1 = $medico_id
                $empresa
                ORDER BY ae.agenda_exames_id)";


        $this->db->query($sql);
    }

    function fecharlaboratorio($data_contaspagar) {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        if ($this->session->userdata('producao_medica_saida') != 't') {
            if ($data_contaspagar == 't') {
                $this->db->set('data', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_escolhida']))));
            } else {
                $this->db->set('data', $data);
            }

            $this->db->set('valor', $_POST['valor']);
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('credor', $_POST['nome']);
            $this->db->set('conta', $_POST['conta']);
            $this->db->set('classe', $_POST['classe']);
            $this->db->set('observacao', $_POST['observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_financeiro_contaspagar');
        } else {
            if ($data_contaspagar == 't') {
                $this->db->set('data', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_escolhida']))));
            } else {
                $this->db->set('data', $data);
            }

            $this->db->set('valor', $_POST['valor']);
            $this->db->set('tipo', $_POST['tipo']);
            $this->db->set('nome', $_POST['nome']);
            $this->db->set('conta', $_POST['conta']);
            $this->db->set('classe', $_POST['classe']);
            $this->db->set('observacao', $_POST['observacao']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_saidas');
        }
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
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('empresa_id,
                            razao_social,
                            producaomedicadinheiro,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->where("ativo", 't');
        $this->db->where("empresa_id IN (
            SELECT empresa_id FROM ponto.tb_operador_empresas WHERE ativo = 't' AND operador_id = $operador_id
        )");
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
        if ($empresa_id == null) {
            $empresa_id = $this->session->userdata('empresa_id');
        }

        $this->db->select('empresa_id,
                            razao_social,
                            logradouro,
                            numero,
                            nome,
                            telefone,
                            email,
                            cnes,
                            horario_sab,
                            horario_seg_sex,
                            producaomedicadinheiro,
                            impressao_declaracao,
                            impressao_orcamento,
                            impressao_internacao,
                            data_contaspagar,
                            medico_laudodigitador,
                            impressao_laudo,
                            chamar_consulta,
                            impressao_recibo,
                            cabecalho_config,
                            rodape_config,
                            laudo_config,
                            recibo_config,
                            ficha_config,
                            declaracao_config,
                            atestado_config,
                            celular,
                            bairro,
                            endereco_integracao_lab,
                            identificador_lis,
                            origem_lis,
                            impressao_tipo');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresa2() {
//        if ($empresa_id == null) {
//            $empresa_id = $this->session->userdata('empresa_id');
//        }

        $this->db->select('empresa_id,
                            razao_social,
                            logradouro,
                            numero,
                            nome,
                            telefone,
                            email,
                            cnes,
                            horario_sab,
                            horario_seg_sex,
                            producaomedicadinheiro,
                            impressao_declaracao,
                            impressao_orcamento,
                            impressao_internacao,
                            data_contaspagar,
                            medico_laudodigitador,
                            impressao_laudo,
                            chamar_consulta,
                            impressao_recibo,
                            cabecalho_config,
                            rodape_config,
                            laudo_config,
                            recibo_config,
                            ficha_config,
                            declaracao_config,
                            atestado_config,
                            celular,
                            bairro,
                            impressao_tipo');
        $this->db->from('tb_empresa');
        $this->db->where('ativo', 'true');
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function creditoempresa($empresa_id = null) {
        if ($empresa_id == null) {
            $empresa_id = $this->session->userdata('empresa_id');
        }

        $this->db->select('e.empresa_id,
                            ordem_chegada,
                            credito,
                            excluir_transferencia,
                            oftamologia,
                            ');
        $this->db->from('tb_empresa e');
        $this->db->where('e.empresa_id', $empresa_id);
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
        $this->db->orderby('e.empresa_id');
        $return = $this->db->get()->result();
        return $return[0]->credito;
    }

    function listarempresasaladeespera($empresa_id = null) {
        if ($empresa_id == null) {
            $empresa_id = $this->session->userdata('empresa_id');
        }

        $this->db->select('e.empresa_id,
                            ordem_chegada,
                            ordenacao_situacao,
                            cancelar_sala_espera,
                            administrador_cancelar,
                            gerente_cancelar_sala,
                            ');
        $this->db->from('tb_empresa e');
        $this->db->where('e.empresa_id', $empresa_id);
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
        $this->db->orderby('e.empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listarconfiguracaoimpressao() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_cabecalho_id,ei.cabecalho,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_cabecalho ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_id', $empresa_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconfiguracaoimpressaoformulario() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_cabecalho_id,ei.cabecalho,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_cabecalho ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_id', $empresa_id);
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconfiguracaoimpressaolaudo() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_laudo_id,ei.cabecalho,ei.texto,ei.adicional_cabecalho,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_laudo ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_id', $empresa_id);
        $this->db->where('ei.ativo', 't');
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconfiguracaoimpressaoorcamento() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_orcamento_id,ei.cabecalho,ei.texto,ei.rodape, e.nome as empresa');
        $this->db->from('tb_empresa_impressao_orcamento ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_id', $empresa_id);
        $this->db->where('ei.ativo', 't');
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarconfiguracaoimpressaorecibo() {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ei.empresa_impressao_recibo_id,ei.cabecalho,ei.texto,ei.rodape, ei.repetir_recibo, e.nome as empresa, linha_procedimento');
        $this->db->from('tb_empresa_impressao_recibo ei');
        $this->db->join('tb_empresa e', 'e.empresa_id = ei.empresa_id', 'left');
        $this->db->where('ei.empresa_id', $empresa_id);
        $this->db->where('ei.ativo', 't');
//        $this->db->where('paciente_id', $paciente_id);
//        $this->db->where('data_criacao', $data);
        $return = $this->db->get();
        return $return->result();
    }

    function listarempresamunicipio() {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('razao_social,
                            logradouro,
                            numero,
                            e.nome,
                            telefone,
                            producaomedicadinheiro,
                            m.estado,
                            m.nome as municipio,
                            impressao_tipo');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_municipio m', 'e.municipio_id = m.municipio_id', 'left');
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

    function gravarguiacirurgica($paciente_id) {
//        var_dump($paciente_id);die;
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->set('via', $_POST['via']);
        $this->db->set('leito', $_POST['leito']);
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('tipo', 'CIRURGICO');
        $this->db->set('data_criacao', $data);
        $this->db->set('convenio_id', $_POST['convenio_id']);
        $this->db->set('paciente_id', $_POST['txtpacienteid']);

        if ($_POST['txtambulatorioguiaid'] == '' || $_POST['txtambulatorioguiaid'] == '0') {
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_guia');
            $ambulatorio_guia_id = $this->db->insert_id();
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                return $ambulatorio_guia_id;
            }
        } else {
            $ambulatorio_guia_id = $_POST['txtambulatorioguiaid'];
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where("ambulatorio_guia_id", $ambulatorio_guia_id);
            $this->db->update('tb_ambulatorio_guia');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                return $ambulatorio_guia_id;
            }
        }
    }

    function gravarguia($paciente_id) {
//        var_dump($_POST);die;
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('tipo', 'EXAME');
        $this->db->set('data_criacao', $data);
        if ($_POST['consulta'] != "particular") {
            $this->db->set('convenio_id', @$_POST['convenio1']);
        }
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_guia');
        $ambulatorio_guia_id = $this->db->insert_id();
        return $ambulatorio_guia_id;
    }

    function gravarguiacirurgicaequipe($procedimentos, $guia) {
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

        for ($i = 0; $i < count($procedimentos); $i++) {
            $valor = (float) $procedimentos[$i]->valor_total;
            $valProcedimento = ($procedimentos[$i]->horario_especial == 't') ? ($valor) + ($valor * $horario_especial) : $valor;

            if ($guia->leito == 'ENFERMARIA') {// LEITO DE ENFERMARIA
                if ($guia->via == 'D') {// VIA DIFERENTE
                    if ($i == 0) {
                        $valMedicoProc = $valProcedimento * $enfermaria_via_diferente['maior'];
                    } else {
                        $valMedicoProc = ($valProcedimento * $enfermaria_via_diferente['base']);
                    }
                } elseif ($guia->via == 'M') {// MESMA VIA
                    if ($i == 0) {
                        $valMedicoProc = $valProcedimento * $enfermaria_mesma_via['maior'];
                    } else {
                        $valMedicoProc = ($valProcedimento * $enfermaria_mesma_via['base']);
                    }
                }
            } else { //APARTAMENTO
                if ($guia->via == 'D') {// VIA DIFERENTE
                    if ($i == 0) {
                        $valMedicoProc = $valProcedimento * $apartamento_via_diferente['maior'];
                    } else {
                        $valMedicoProc = ($valProcedimento * $apartamento_via_diferente['base']);
                    }
                } elseif ($guia->via == 'M') {// MESMA VIA
                    if ($i == 0) {
                        $valMedicoProc = $valProcedimento * $apartamento_mesma_via['maior'];
                    } else {
                        $valMedicoProc = $valProcedimento * $apartamento_mesma_via['base'];
                    }
                }
            }

            //VALOR DO CIRURGIAO/ANESTESISTA
            $valMedico = $valMedicoProc;
//            var_dump($guia->leito, $guia->via); die;

            if ((int) $_POST['funcao'] != 0) {
                $this->db->select('valor');
                $this->db->from('tb_centrocirurgico_percentual_funcao');
                $this->db->where("funcao", $_POST['funcao']);
                $query = $this->db->get();
                $return2 = $query->result();

                //DEFININDO OS VALORES
                $val = number_format($valMedico * ($return2[0]->valor / 100), 2, '.', '');
            } else {
                $val = number_format($valMedico, 2, '.', '');
            }

//            echo "<pre>";
//            var_dump($val); echo "<hr>";

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('operador_responsavel', $_POST['medico']);
            $this->db->set('agenda_exames_id', $procedimentos[$i]->agenda_exames_id);
            $this->db->set('valor', $val);
            $this->db->set('funcao', $_POST['funcao']);
            $this->db->insert('tb_agenda_exame_equipe');
        }
//        die;
    }

    function gravarorcamentorecepcao($paciente_id) {
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
//        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->set('empresa_id', $_POST['empresa1']);
        $this->db->set('data_criacao', $data);
//        if ($paciente_id == null) {
//            $this->db->set('cadastro', 'f');
//        }
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_orcamento');
        $ambulatorio_guia_id = $this->db->insert_id();
        return $ambulatorio_guia_id;
    }

    function gravarorcamentorecepcaonaocadastro($paciente_id) {
        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('data_criacao', $data);
        if ($paciente_id == null) {
            $this->db->set('cadastro', 'f');
        }
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_ambulatorio_orcamento');
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

    function gravarexames($ambulatorio_guia_id, $medico_id, $percentual, $percentual_laboratorio, $medicopercentual) {
        try {
//            var_dump($_POST); die;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro, fidelidade_endereco_ip');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;
            $fidelidade_endereco_ip = $return[0]->fidelidade_endereco_ip;

            $this->db->select('ep.ajuste_pagamento_procedimento as ajustepagamento');
            $this->db->from('tb_empresa e');
            $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
            $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
            $this->db->orderby('e.empresa_id');
            $flags = $this->db->get()->result();


            if ($_POST['indicacao'] != "") {
                $this->db->select('mc.valor as valor_promotor, mc.percentual as percentual_promotor');
                $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
                $this->db->join('tb_procedimento_percentual_promotor m', 'm.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id', 'left');
                $this->db->where('m.procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->where('mc.promotor', $_POST['indicacao']);
                $this->db->where('mc.ativo', 'true');
//          $this->db->where('pc.ativo', 'true');
//          $this->db->where('pt.ativo', 'true');
                $return2 = $this->db->get()->result();
            } else {
                $return2 = array();
            }
//            var_dump($return2); die;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            if (count($return2) > 0) {
                $this->db->set('valor_promotor', $return2[0]->valor_promotor);
                $this->db->set('percentual_promotor', $return2[0]->percentual_promotor);
            }
            if (count($percentual_laboratorio) > 0) {
                $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
                $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
                $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
            }
            $empresa_id = $this->session->userdata('empresa_id');
//            var_dump($percentual_laboratorio); die;
            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            if ($medicopercentual != "") {
                $this->db->set('medico_agenda', $medicopercentual);
                $this->db->set('medico_consulta_id', $medicopercentual);
            }

            $valorProc = $_POST['valor1'];

            if (((float) $_POST['valorAjuste'] != 0)) {
                $this->db->set('procedimento_possui_ajuste_pagamento', 't');
                $this->db->set('valor_forma_pagamento_ajuste', (float) $_POST['valorAjuste']);
            }
            $this->db->set('valor', $valorProc);
            $valortotal = $valorProc * $_POST['qtde1'];
            $this->db->set('valor_total', $valortotal);
//            $this->db->set('percentual_medico', $valor_percentual);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
            $this->db->set('guiaconvenio', $_POST['guiaconvenio']);
//            $this->db->set('observacoes', $_POST['observacao']);
            if ($_POST['ordenador'] != "") {
                $this->db->set('ordenador', $_POST['ordenador']);
            }
            if ($_POST['indicacao'] != "") {
                $this->db->set('indicacao', $_POST['indicacao']);
            }
            if ($_POST['data'] != "") {
                $this->db->set('data_entrega', $_POST['data']);
            }
            $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
            $this->db->set('inicio', $hora);
            $this->db->set('fim', $hora);
            if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                if ($flags[0]->ajustepagamento != 't') {
                    $this->db->set('faturado', 't');
                    $this->db->set('valor1', $valortotal);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('forma_pagamento', $_POST['formapamento']);
                } else {
                    $this->db->set('forma_pagamento_ajuste', $_POST['formapamento']);
                    $this->db->set('valor_forma_pagamento_ajuste', (float) $_POST['valorAjuste']);
                }
            }

            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('confirmado', 't');
            $this->db->set('tipo', 'EXAME');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $ambulatorio_guia_id);

            $this->db->set('paciente_id', $_POST['txtpaciente_id']);

            $this->db->set('medico_solicitante', $medico_id);
            $this->db->set('data_faturar', $data);
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

                if ($fidelidade_endereco_ip != '') {
                    $numero_consultas = 1;
                    $tipo_grupo = $this->verificatipoprocedimento($_POST['procedimento1']);
//                        $cpf = $this->verificatipoprocedimento($procedimento_tuss_id);
                    $this->db->select('p.cpf');
                    $this->db->from('tb_paciente p');
                    $this->db->where("p.paciente_id", $_POST['txtpaciente_id']);
                    $dados_paciente = $this->db->get()->result();




                    $informacoes['paciente_id'] = $_POST['txtpaciente_id'];
                    $informacoes['procedimento'] = $_POST['procedimento1'];
                    $informacoes['parceiro_id'] = $_POST['convenio1'];
                    $informacoes['cpf'] = @$dados_paciente[0]->cpf;
                    $informacoes['grupo'] = $tipo_grupo;
                    $informacoes['agenda_exames_id'] = $agenda_exames_id;
                    $informacoes['numero_consultas'] = $numero_consultas;
                    $informacoes['valor'] = $_POST['valor1'];

                    $fidelidade = $this->autorizarpacientefidelidade($fidelidade_endereco_ip, $informacoes);
                    if ($fidelidade == 'pending' || $fidelidade == 'no_exists') { // Caso esteja com pagamento pendente
                        $this->db->where('agenda_exames_id', $agenda_exames_id);
                        $this->db->delete('tb_agenda_exames');

                        return array(
                            "cod" => -1,
                            "message" => $fidelidade
                        );
                    }
//                    $fidelidade = 'false';
//                        var_dump($fidelidade);
//                        die;
                    if ($fidelidade == 'true') {
                        $fidelidade_liberado = true;
                    } elseif ($fidelidade == 'false') {
                        $fidelidade_liberado = false;
                    } else {
                        $fidelidade_liberado = false;
                    }
                } else {
                    $fidelidade_liberado = false;
                }


                if ($fidelidade_liberado) {
                    $this->db->set('valor', 0);
                    $this->db->set('valor_total', $valortotal);
                } else {
                    $this->db->set('valor', $valorProc);
                    $this->db->set('valor_total', $valortotal);
                }

                if ($fidelidade_liberado) {
                    $this->db->set('faturado', 't');
//                        $this->db->set('forma_pagamento', $formapagamento);
                    $this->db->set('valor1', 0);
//                        $this->db->set('valor_total', $valor);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('data_faturamento', $horario);
                } elseif ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                    if ($flags[0]->ajustepagamento != 't') {
                        $this->db->set('faturado', 't');
                        $this->db->set('valor1', $valortotal);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                        $this->db->set('forma_pagamento', $_POST['formapamento']);
                    } else {
                        $this->db->set('forma_pagamento_ajuste', $_POST['formapamento']);
                        $this->db->set('valor_forma_pagamento_ajuste', (float) $_POST['valorAjuste']);
                    }
                }

                $this->db->set('senha', md5($agenda_exames_id));
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');


                $this->db->select('ep.autorizar_sala_espera');
                $this->db->from('tb_empresa e');
                $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
                $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
                $this->db->orderby('e.empresa_id');
                $sala_de_espera_p = $this->db->get()->result();

                if (@$sala_de_espera_p[0]->autorizar_sala_espera == 'f') {

                    $tipo_grupo = $this->verificatipoprocedimento($_POST['procedimento1']);
                    $dados['agenda_exames_id'] = $agenda_exames_id;
                    $dados['medico'] = $medicopercentual;
                    $dados['paciente_id'] = $_POST['txtpaciente_id'];
                    $dados['procedimento_tuss_id'] = $_POST['procedimento1'];
                    $dados['sala_id'] = $_POST['sala1'];
                    $dados['guia_id'] = $ambulatorio_guia_id;
                    $dados['tipo'] = $tipo_grupo;

                    $this->enviarsaladeespera($dados);
                }
            }

//            if( (isset($_POST['indicacao']) && isset($_POST['indicacao_paciente'])) && ($_POST['indicacao'] != $_POST['indicacao_paciente'])){
//                $this->db->set('indicacao_id', $_POST['indicacao']);
//                $this->db->where('ambulatorio_guia_id',$ambulatorio_guia_id);
//                $this->db->update('tb_ambulatorio_guia');
//            }

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

    function autorizarpacientefidelidade($endereco, $informacoes) {
        $paciente_id = $informacoes['paciente_id'];
        $procedimento = $informacoes['procedimento'];
        $parceiro_id = $informacoes['parceiro_id'];
        $cpf = $informacoes['cpf'];
        $grupo = $informacoes['grupo'];
        $valor = $informacoes['valor'];
        $agenda_exames_id = $informacoes['agenda_exames_id'];
        $numero_consultas = $informacoes['numero_consultas'];
//        echo "<pre>";
//        var_dump("http://{$endereco}/autocomplete/autorizaratendimentoweb?paciente_id=$paciente_id&procedimento=$procedimento&parceiro_id=$parceiro_id&cpf=$cpf&grupo=$grupo&agenda_exames_id=$agenda_exames_id&numero_consultas=$numero_consultas&valor=$valor"); die;
        $return = file_get_contents("http://{$endereco}/autocomplete/autorizaratendimentoweb?paciente_id=$paciente_id&procedimento=$procedimento&parceiro_id=$parceiro_id&cpf=$cpf&grupo=$grupo&agenda_exames_id=$agenda_exames_id&numero_consultas=$numero_consultas&valor=$valor");
        $resposta = json_decode($return);
//        var_dump($return);
//        die;
        // Caso venha "no_exists" o paciente não existe no Fidelidade
        return $resposta;
    }

    function verificatipoprocedimento($procedimento_convenio_id) {

        $this->db->select('ag.tipo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_convenio_id);
        $query = $this->db->get();
        $tipo = $query->result();
        return $tipo[0]->tipo;
    }

    function gravarexamesagrupador($ambulatorio_guia_id, $medico_id, $agrupador_id, $procedimento, $valor, $valor_diferenciado, $percentual, $percentual_laboratorio, $grupo, $quantidade = 1) {
        try {
//            var_dump($_POST); die;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;
            if ($_POST['indicacao'] != "") {
                $this->db->select('mc.valor as valor_promotor, mc.percentual as percentual_promotor');
                $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
                $this->db->join('tb_procedimento_percentual_promotor m', 'm.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id', 'left');
                $this->db->where('m.procedimento_tuss_id', $procedimento);
                $this->db->where('mc.promotor', $_POST['indicacao']);
                $this->db->where('mc.ativo', 'true');
//          $this->db->where('pc.ativo', 'true');
//          $this->db->where('pt.ativo', 'true');
                $return2 = $this->db->get()->result();
            } else {
                $return2 = array();
            }
//            var_dump($return2); die;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            if (count($return2) > 0) {
                $this->db->set('valor_promotor', $return2[0]->valor_promotor);
                $this->db->set('percentual_promotor', $return2[0]->percentual_promotor);
            }
            if (count($percentual_laboratorio) > 0) {
                $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
                $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
                $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
            }
//            var_dump($percentual_laboratorio); die;
            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
            $this->db->set('procedimento_tuss_id', $procedimento);
            if ($_POST['medicoagenda'] != "") {
                $this->db->set('medico_agenda', $_POST['medicoagenda']);
                $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
            }
            $this->db->set('valor', $valor);
            $valortotal = $_POST['valor1'] * $quantidade;
            $this->db->set('valor_total', $valor);
//            $this->db->set('percentual_medico', $valor_percentual);
            $this->db->set('quantidade', $quantidade);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
            $this->db->set('guiaconvenio', $_POST['guiaconvenio']);
//            $this->db->set('observacoes', $_POST['observacao']);
            if ($_POST['ordenador'] != "") {
                $this->db->set('ordenador', $_POST['ordenador']);
            }
            if ($_POST['indicacao'] != "") {
                $this->db->set('indicacao', $_POST['indicacao']);
            }
            if ($_POST['data'] != "") {
                $this->db->set('data_entrega', $_POST['data']);
            }
            $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
            $this->db->set('inicio', $hora);
            $this->db->set('fim', $hora);
            if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                $this->db->set('faturado', 't');
                $this->db->set('valor1', $valor);
                $this->db->set('operador_faturamento', $operador_id);
                $this->db->set('data_faturamento', $horario);
                $this->db->set('forma_pagamento', $_POST['formapamento']);
            }
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('confirmado', 't');
            $this->db->set('tipo', $grupo);
            if ($grupo == 'MEDICAMENTO' || $grupo == 'MATERIAL') {
                $this->db->set('realizada', 't');
            }
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $ambulatorio_guia_id);

            $this->db->set('agrupador_pacote_id', $agrupador_id);
            $this->db->set('pacote_diferenciado', $valor_diferenciado);

            $this->db->set('paciente_id', $_POST['txtpaciente_id']);

            $this->db->set('medico_solicitante', $medico_id);
            $this->db->set('data_faturar', $data);
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

                if ($grupo == 'MEDICAMENTO' || $grupo == 'MATERIAL') {

                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('procedimento_tuss_id', $procedimento);
                    $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                    $this->db->set('medico_realizador', $_POST['medicoagenda']);
                    $this->db->set('situacao', 'FINALIZADO');
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('agenda_exames_id', $agenda_exames_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_exames');
                    $exames_id = $this->db->insert_id();
                }
            }

//            if( (isset($_POST['indicacao']) && isset($_POST['indicacao_paciente'])) && ($_POST['indicacao'] != $_POST['indicacao_paciente'])){
//                $this->db->set('indicacao_id', $_POST['indicacao']);
//                $this->db->where('ambulatorio_guia_id',$ambulatorio_guia_id);
//                $this->db->update('tb_ambulatorio_guia');
//            }

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

    function gravaragrupadorpacote($procedimento_convenio_id) {

        $this->db->select(" pc.valortotal as valor_pacote,
                            pc.valor_pacote_diferenciado,
                            pc2.valortotal");
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimentos_agrupados_ambulatorial pa', 'pa.procedimento_agrupador_id = pc.procedimento_tuss_id');
        $this->db->join('tb_procedimento_convenio pc2', 'pc2.procedimento_tuss_id = pa.procedimento_tuss_id');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_convenio_id);
        $this->db->where("pc2.convenio_id = pc.convenio_id");
        $this->db->where("pa.ativo", 't');
        $this->db->where("pc2.ativo", 't');
        $query = $this->db->get();
        $procedimentos = $query->result();

        if ($procedimentos[0]->valor_pacote_diferenciado == 'f') {
            $valor = 0;
            foreach ($procedimentos as $value) {
                $valor += (float) $value->valortotal;
            }
        } else {
            $valor = (float) $procedimentos[0]->valor_pacote;
        }

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->set('procedimento_agrupador_id', $procedimento_convenio_id);
        $this->db->set('valor_diferenciado', $procedimentos[0]->valor_pacote_diferenciado);
        $this->db->set('valor_pacote', $valor);
        $this->db->set('qtde_procedimentos', count($procedimentos));
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_agrupador_pacote_temp');
        $agrupador_id = $this->db->insert_id();
        return $agrupador_id;
    }

    function listarprocedimentospacote($procedimento_convenio_id) {
        // 
        $this->db->select(" pc.valortotal as valor_pacote,
                            pc.valor_pacote_diferenciado,
                            pa.quantidade_agrupador,,
                            pc2.valortotal,
                            pc2.procedimento_convenio_id,
                            pt.grupo");
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimentos_agrupados_ambulatorial pa', 'pa.procedimento_agrupador_id = pc.procedimento_tuss_id');
        $this->db->join('tb_procedimento_convenio pc2', 'pc2.procedimento_tuss_id = pa.procedimento_tuss_id');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc2.procedimento_tuss_id');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_convenio_id);
        $this->db->where("pc2.convenio_id = pc.convenio_id");
        $this->db->where("pa.ativo", 't');
        $this->db->where("pc2.ativo", 't');
        $this->db->orderby("pc2.valortotal");
        $query = $this->db->get();
        return $query->result();
    }

    function verificaexamemedicamento($procedimento_convenio_id) {

        $this->db->select('ag.tipo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_convenio_id);
//        $this->db->where("pt.agrupador = 'f'");
        $query = $this->db->get();
        $tipo = $query->result();
        return $tipo[0]->tipo;
    }

    function verificaprocedimentoagrupador($procedimento_convenio_id) {

        $this->db->select('ag.tipo, pt.agrupador');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo');
        $this->db->where("pc.procedimento_convenio_id", $procedimento_convenio_id);
        $query = $this->db->get();
        return $query->result();
    }

    function gravaratendimentoagrupador($ambulatorio_guia_id, $medico_id, $agrupador_id, $procedimento, $valor, $valor_diferenciado, $percentual, $percentual_laboratorio, $grupo, $quantidade = 1) {
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
                if ($_POST['indicacao'] != "") {
                    $this->db->select('mc.valor as valor_promotor, mc.percentual as percentual_promotor');
                    $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
                    $this->db->join('tb_procedimento_percentual_promotor m', 'm.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $procedimento);
                    $this->db->where('mc.promotor', $_POST['indicacao']);
                    $this->db->where('mc.ativo', 'true');
                    $return2 = $this->db->get()->result();
                } else {
                    $return2 = array();
                }

                if ($index == 1) {
                    if (count($return2) > 0) {
                        $this->db->set('valor_promotor', $return2[0]->valor_promotor);
                        $this->db->set('percentual_promotor', $return2[0]->percentual_promotor);
                        $this->db->set('indicacao', $_POST['indicacao']);
                    }
                }

                if (count($percentual_laboratorio) > 0) {
                    $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
                    $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
                    $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
                }

                $hora = date("H:i:s");
                $data = date("Y-m-d");

                $this->db->set('valor_medico', $percentual[0]->perc_medico);
                $this->db->set('percentual_medico', $percentual[0]->percentual);
                $this->db->set('procedimento_tuss_id', $procedimento);
                if ($_POST['medicoagenda'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                    $this->db->set('medico_agenda', $_POST['medicoagenda']);
                }
                $this->db->set('convenio_id', $_POST['convenio1']);
                $this->db->set('quantidade', $quantidade);
                if ($dinheiro == "t") {
                    if ($index == 1) {
                        $this->db->set('valor', $valor);
                        $this->db->set('valor_total', $valor * $quantidade);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', 0);
                        $this->db->set('confirmado', 'f');
                    }
                } else {
                    if ($index == 1) {
                        $this->db->set('valor', $valor);
                        $this->db->set('valor_total', $valor * $quantidade);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $valor);
                        $this->db->set('valor_total', $valor * $quantidade);
                        $this->db->set('confirmado', 'f');
                    }
                }
                $this->db->set('autorizacao', $_POST['autorizacao1']);
                if ($_POST['ordenador'] != "") {
                    $this->db->set('ordenador', $_POST['ordenador']);
                }
                if ($medico_id != "") {
                    $this->db->set('medico_solicitante', $medico_id);
                }
                $this->db->set('tipo', $grupo);
                $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
                $this->db->set('inicio', $hora);
                $this->db->set('fim', $hora);
                if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                    $this->db->set('faturado', 't');
                    $this->db->set('valor1', $valor);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('forma_pagamento', $_POST['formapamento']);
                }
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('quantidade', $quantidade);
                $this->db->set('ativo', 'f');
                if ($grupo == 'MEDICAMENTO' || $grupo == 'MATERIAL') {
//                    Se for medicamento ou material já envia da sala de espera
                    $this->db->set('realizada', 't');
                }

                $this->db->set('situacao', 'OK');
                $this->db->set('guia_id', $ambulatorio_guia_id);

                $this->db->set('agrupador_pacote_id', $agrupador_id);
                $this->db->set('pacote_diferenciado', $valor_diferenciado);

                $this->db->set('numero_sessao', $index);
                $this->db->set('qtde_sessao', $qtde);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('data', $data);
                $this->db->set('data_faturar', $data);
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

                if ($grupo == 'MEDICAMENTO' || $grupo == 'MATERIAL') {

                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('procedimento_tuss_id', $procedimento);
                    $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                    $this->db->set('medico_realizador', $_POST['medicoagenda']);
                    $this->db->set('situacao', 'FINALIZADO');
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('agenda_exames_id', $agenda_exames_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_exames');
                    $exames_id = $this->db->insert_id();
                }
            }
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaratendimemto($ambulatorio_guia_id, $medico_id, $percentual, $percentual_laboratorio) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro, fidelidade_endereco_ip');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;
            $fidelidade_endereco_ip = $return[0]->fidelidade_endereco_ip;

            $this->db->select('ep.ajuste_pagamento_procedimento as ajustepagamento');
            $this->db->from('tb_empresa e');
            $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
            $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
            $this->db->orderby('e.empresa_id');
            $flags = $this->db->get()->result();
//            var_dump("<hr>",$flags); die;
            $endereco_toten = $this->session->userdata('endereco_toten');
            if ($endereco_toten != '') {
                // echo $_POST['txtpaciente_id']; die;
                $this->db->set('toten_fila_id', $_POST['toten_fila_id']);
                $this->db->where('paciente_id', $_POST['txtpaciente_id']);
                $this->db->update('tb_paciente');
            }


            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $qtde = (int) $_POST['qtde'];
//            var_dump($qtde);die;
            for ($index = 1; $index <= $qtde; $index++) {
                if ($_POST['indicacao'] != "") {
                    $this->db->select('mc.valor as valor_promotor, mc.percentual as percentual_promotor');
                    $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
                    $this->db->join('tb_procedimento_percentual_promotor m', 'm.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $_POST['procedimento1']);
                    $this->db->where('mc.promotor', $_POST['indicacao']);
                    $this->db->where('mc.ativo', 'true');
//          $this->db->where('pc.ativo', 'true');
//          $this->db->where('pt.ativo', 'true');
                    $return2 = $this->db->get()->result();
                } else {
                    $return2 = array();
                }
//            var_dump($return2); die;

                if ($index == 1) {
                    if (count($return2) > 0) {
//                        var_dump($index, $_POST['indicacao']);
                        $this->db->set('valor_promotor', $return2[0]->valor_promotor);
                        $this->db->set('percentual_promotor', $return2[0]->percentual_promotor);
                        $this->db->set('indicacao', $_POST['indicacao']);
                    }
                }

                $hora = date("H:i:s");
                $data = date("Y-m-d");

                $this->db->set('valor_medico', $percentual[0]->perc_medico);
                $this->db->set('percentual_medico', $percentual[0]->percentual);
                if (count($percentual_laboratorio) > 0) {
                    $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
                    $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
                    $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
                }
                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                if ($_POST['medicoagenda'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                    $this->db->set('medico_agenda', $_POST['medicoagenda']);
                }
                $this->db->set('convenio_id', $_POST['convenio1']);
//                $this->db->set('quantidade', '1');
                $valorProc = $_POST['valor1'];

                if (((float) $_POST['valorAjuste'] != 0)) {
                    $this->db->set('procedimento_possui_ajuste_pagamento', 't');
                }

                if ($dinheiro == "t") {
                    if ($index == 1) {
                        $this->db->set('valor', $valorProc);
                        $this->db->set('valor_total', $valorProc);
                        $this->db->set('confirmado', 't');
                    } else {
//                        die;
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', 0);
                        $this->db->set('confirmado', 'f');
                    }
                } else {
                    if ($index == 1) {
                        $this->db->set('valor', $valorProc);
                        $this->db->set('valor_total', $valorProc);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $valorProc);
                        $this->db->set('valor_total', $valorProc);
                        $this->db->set('confirmado', 'f');
                    }
                }
                $this->db->set('autorizacao', $_POST['autorizacao1']);
                if ($_POST['ordenador'] != "") {
                    $this->db->set('ordenador', $_POST['ordenador']);
                }
                if ($_POST['indicacao'] != "") {
                    $this->db->set('indicacao', $_POST['indicacao']);
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
                    if ($flags[0]->ajustepagamento != 't') {
                        $this->db->set('faturado', 't');
                        $this->db->set('valor1', $_POST['valor1']);
                        $this->db->set('data_faturamento', $horario);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('forma_pagamento', $_POST['formapamento']);
                    } else {
                        $this->db->set('forma_pagamento_ajuste', $_POST['formapamento']);
                        $this->db->set('valor_forma_pagamento_ajuste', (float) $_POST['valorAjuste']);
                    }
                }
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('quantidade', (int) $_POST['qtde1']);
                $this->db->set('ativo', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('guia_id', $ambulatorio_guia_id);
//                $this->db->set('agrupador_fisioterapia', $ambulatorio_guia_id);
                $this->db->set('numero_sessao', $index);
                $this->db->set('qtde_sessao', $qtde);
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('data', $data);
                $this->db->set('data_faturar', $data);
                $this->db->set('data_autorizacao', $horario);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('operador_autorizacao', $operador_id);
                $this->db->insert('tb_agenda_exames');
//                die;
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return -1;
                } else {
                    $agenda_exames_id = $this->db->insert_id();

                    if ($fidelidade_endereco_ip != '' && $index == 1) {
//                        var_dump('asdasd');die;
                        $numero_consultas = 1;
                        $tipo_grupo = $this->verificatipoprocedimento($_POST['procedimento1']);
//                        $cpf = $this->verificatipoprocedimento($procedimento_tuss_id);
                        $this->db->select('p.cpf');
                        $this->db->from('tb_paciente p');
                        $this->db->where("p.paciente_id", $_POST['txtpaciente_id']);
                        $dados_paciente = $this->db->get()->result();

//                        $this->db->select('tipo');
//                        $this->db->from('tb_agenda_exames ae');
//                        $this->db->where("agenda_exames_id", $agenda_exames_id);
//                        $exame = $this->db->get()->result();


                        $informacoes['paciente_id'] = $_POST['txtpaciente_id'];
                        $informacoes['procedimento'] = $_POST['procedimento1'];
                        $informacoes['parceiro_id'] = $_POST['convenio1'];
                        $informacoes['cpf'] = @$dados_paciente[0]->cpf;
                        $informacoes['grupo'] = $tipo_grupo;
                        $informacoes['agenda_exames_id'] = $agenda_exames_id;
                        $informacoes['numero_consultas'] = $numero_consultas;
                        $informacoes['valor'] = $_POST['valor1'];


                        $fidelidade = $this->autorizarpacientefidelidade($fidelidade_endereco_ip, $informacoes);
                        if ($fidelidade == 'pending' || $fidelidade == 'no_exists') { // Caso esteja com pagamento pendente
                            $this->db->where('agenda_exames_id', $agenda_exames_id);
                            $this->db->delete('tb_agenda_exames');

                            return array(
                                "cod" => -1,
                                "message" => $fidelidade
                            );
                        }

                        if ($fidelidade == 'true') {
                            $fidelidade_liberado = true;
                        } elseif ($fidelidade == 'false') {
                            $fidelidade_liberado = false;
                        } else {
                            $fidelidade_liberado = false;
                        }
                    } else {
                        $fidelidade_liberado = false;
                    }


                    if ($fidelidade_liberado) {
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', $_POST['valor1']);
                    } else {
                        $this->db->set('valor', $valorProc);
                        $this->db->set('valor_total', $valorProc);
                    }

                    if ($fidelidade_liberado) {
                        $this->db->set('faturado', 't');
//                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', 0);
//                        $this->db->set('valor_total', $valor);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    } elseif ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                        if ($flags[0]->ajustepagamento != 't') {
                            $this->db->set('faturado', 't');
                            if ($index == 1) {
                                $this->db->set('valor1', $valorProc);
                            } else {
                                $this->db->set('valor1', 0);
                            }
                            $this->db->set('operador_faturamento', $operador_id);
                            $this->db->set('data_faturamento', $horario);
                            $this->db->set('forma_pagamento', $_POST['formapamento']);
                        } else {
                            $this->db->set('forma_pagamento_ajuste', $_POST['formapamento']);
                            $this->db->set('valor_forma_pagamento_ajuste', (float) $_POST['valorAjuste']);
                        }
                    }

                    $this->db->set('senha', md5($agenda_exames_id));
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
//                    die;

                    $this->db->select('ep.autorizar_sala_espera');
                    $this->db->from('tb_empresa e');
                    $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
                    $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
                    $this->db->orderby('e.empresa_id');
                    $sala_de_espera_p = $this->db->get()->result();

                    if (@$sala_de_espera_p[0]->autorizar_sala_espera == 'f') {

                        $tipo_grupo = $this->verificatipoprocedimento($_POST['procedimento1']);
                        $dados['agenda_exames_id'] = $agenda_exames_id;
                        $dados['medico'] = $_POST['medicoagenda'];
                        $dados['paciente_id'] = $_POST['txtpaciente_id'];
                        $dados['procedimento_tuss_id'] = $_POST['procedimento1'];
                        $dados['sala_id'] = $_POST['sala1'];
                        $dados['guia_id'] = $ambulatorio_guia_id;
                        $dados['tipo'] = $tipo_grupo;

                        $this->enviarsaladeespera($dados);
                    }
                }
            }
        } catch (Exception $exc) {
            return -1;
        }
    }

    function enviarsaladeespera($dados) {

        $agenda_exames_id = $dados['agenda_exames_id'];
        $medico = $dados['medico'];
        $paciente_id = $dados['paciente_id'];
        $procedimento_tuss_id = $dados['procedimento_tuss_id'];
        $sala_id = $dados['sala_id'];
        $guia_id = $dados['guia_id'];
        $tipo = $dados['tipo'];

        $horario = date("Y-m-d H:i:s");
        $data = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');
        $empresa_id = $this->session->userdata('empresa_id');
        $exame_id = $agenda_exames_id;
//            echo '<pre>';
//            var_dump($_POST);
//            var_dump($procedimento_tuss_id);
//            var_dump($guia_id);
//            var_dump($agenda_exames_id);
//            var_dump($tipo);
//            die;


        $this->db->select('al.ambulatorio_laudo_id');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->join('tb_exames ae', 'ae.exames_id = al.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->where("age.agenda_exames_id is not null");
        $this->db->where("al.data <=", $data);
        $this->db->where("age.paciente_id", $paciente_id);
        $this->db->where("al.medico_parecer1", $medico);
        $atendimentos = $this->db->get()->result();

        $this->db->select('data_senha, senha, toten_fila_id, toten_senha_id');
        $this->db->from('tb_paciente p');
        $this->db->where("p.paciente_id", $paciente_id);
        $paciente_inf = $this->db->get()->result();




//            var_dump($atendimentos); die;
        if (count($atendimentos) > 0) {
            $primeiro_atendimento = 'f';
        } else {
            $primeiro_atendimento = 't';
        }

        $this->db->select('ppmc.dia_recebimento, ppmc.tempo_recebimento');
        $this->db->from('tb_procedimento_percentual_medico ppm');
        $this->db->join("tb_procedimento_percentual_medico_convenio ppmc", "ppmc.procedimento_percentual_medico_id = ppm.procedimento_percentual_medico_id");
        $this->db->where("ppm.procedimento_tuss_id", $procedimento_tuss_id);
        $this->db->where("ppmc.medico", $medico);
        $this->db->where("ppmc.ativo", 't');
        $this->db->where("ppm.ativo", 't');
        $retorno = $this->db->get()->result();

//            echo "<pre>"; var_dump($retorno); die;
        if (count($retorno) > 0 && @$retorno[0]->dia_recebimento != '' && @$retorno[0]->tempo_recebimento != '') {
            if (date("d") > $retorno[0]->dia_recebimento) {
                $d = date("Y-m-", strtotime("+1 month")) . $retorno[0]->dia_recebimento;
                $dataProducao = date("Y-m-d", strtotime("+" . $retorno[0]->tempo_recebimento . " days", strtotime($d)));
            } else {
                $d = date("Y-m-") . $retorno[0]->dia_recebimento;
                $dataProducao = date("Y-m-d", strtotime("+" . $retorno[0]->tempo_recebimento . " days", strtotime($d)));
            }
        } else {
            $dataProducao = $data;
        }

//                $this->db->set('ativo', 'f');
//                $this->db->where('exame_sala_id', $_POST['txtsalas']);
//                $this->db->update('tb_exame_sala');

        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('paciente_id', $paciente_id);

        $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->set('guia_id', $guia_id);
        $this->db->set('tipo', $tipo);
        $this->db->set('agenda_exames_id', $agenda_exames_id);
        $this->db->set('sala_id', $sala_id);
        if ($medico != "") {
            $this->db->set('medico_realizador', $medico);
        }

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_exames');
        $exames_id = $this->db->insert_id();

        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('data', $data);
        if (count($paciente_inf) > 0) {
            $this->db->set('toten_senha_id', $paciente_inf[0]->toten_senha_id);
            $this->db->set('toten_fila_id', $paciente_inf[0]->toten_fila_id);
            $this->db->set('senha ', $paciente_inf[0]->senha);
            $this->db->set('data_senha', $paciente_inf[0]->data_senha);
        }

        $this->db->set('data_producao', $dataProducao);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
        $this->db->set('exame_id', $exames_id);
        $this->db->set('guia_id', $guia_id);
        $this->db->set('tipo', $tipo);
        $this->db->set('primeiro_atendimento', $primeiro_atendimento);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        if ($medico != "") {
            $this->db->set('medico_parecer1', $medico);
        }
//        $this->db->set('id_chamada', $_POST['idChamada']);
        $this->db->insert('tb_ambulatorio_laudo');
        $laudo_id = $this->db->insert_id();

        if ($medico != "") {
            $this->db->set('medico_consulta_id', $medico);
            $this->db->set('medico_agenda', $medico);
            // $this->db->set('valor_medico', $percentual[0]->perc_medico);
            // $this->db->set('percentual_medico', $percentual[0]->percentual);
        }
        $this->db->set('realizada', 'true');
        $this->db->set('cancelada', 'false');
        $this->db->set('senha', md5($exame_id));
        $this->db->set('data_realizacao', $horario);
        $this->db->set('operador_realizacao', $operador_id);

        $this->db->set('agenda_exames_nome_id', $sala_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');

        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('agenda_exames_id', $agenda_exames_id);
        $this->db->set('sala_id', $sala_id);
        $this->db->set('paciente_id', $paciente_id);
        $this->db->insert('tb_ambulatorio_chamada');

        return true;
    }

    function gravarorcamentoitemrecepcao($ambulatorio_orcamento_id, $paciente_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            if ($_POST['ajustevalor1'] != '') {
                $this->db->set('valor_ajustado', $_POST['ajustevalor1']);
            }
            $this->db->set('valor', $_POST['valor1']);
            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
//            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $_POST['empresa1']);
            if (isset($_POST['observacao'])) {
                $this->db->set('observacao', $_POST['observacao']);
            }

            $this->db->set('orcamento_id', $ambulatorio_orcamento_id);

            if ($_POST['formapamento'] != '') {
                $this->db->set('forma_pagamento', $_POST['formapamento']);
            }

            if ($_POST['txtdata'] != '') {
                $this->db->set('data_preferencia', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['txtdata']))));
            }
//            $this->db->set('turno_prefencia', $_POST['turno_preferencia']);
            if ($_POST['turno_preferencia'] != '') {
                $this->db->set('horario_preferencia', $_POST['turno_preferencia']);
            }


            $this->db->set('paciente_id', $paciente_id);
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

    function gravarorcamentoitemrecepcaomultiplo($ambulatorio_orcamento_id, $paciente_id, $procedimento_convenio_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('pc.valortotal');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->where("pc.procedimento_convenio_id", $procedimento_convenio_id);
            $procedimento_Re = $this->db->get()->result();
            // echo '<pre>'; 
            // var_dump($procedimento_Re); 
            // die;
            $valor_proc = $procedimento_Re[0]->valortotal;
            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $procedimento_convenio_id);

            $this->db->set('valor', $valor_proc);
            $valortotal = $valor_proc * 1;
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', 1);
//            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $_POST['empresa1']);
            $this->db->set('orcamento_id', $ambulatorio_orcamento_id);
            $this->db->set('paciente_id', $paciente_id);
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

    function gravarorcamentoitemrecepcaomultiplodetalhes($ambulatorio_orcamento_id, $paciente_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $data = date("Y-m-d");
            // $contador = 0;
            foreach ($_POST['orcamento_item_id'] as $key => $orcamento_item_id) {
                if ($orcamento_item_id > 0) {

                    $data_preferencia = $_POST['txtdata'][$key];
                    $turno_preferencia = $_POST['turno_preferencia'][$key];
                    $formapamento = $_POST['formapamento'][$key];
                    $ajustevalor = $_POST['ajustevalor'][$key];
                    // var_dump($data_preferencia); die;
                    $this->db->set('detalhes', 't');

                    if ($ajustevalor != '') {
                        $this->db->set('valor_ajustado', $ajustevalor);
                    }
                    if ($formapamento != '') {
                        $this->db->set('forma_pagamento', $formapamento);
                    }

                    if ($data_preferencia != '') {
                        $this->db->set('data_preferencia', date("Y-m-d", strtotime(str_replace("/", "-", $data_preferencia))));
                    }
                    //            $this->db->set('turno_prefencia', $_POST['turno_preferencia']);
                    if ($turno_preferencia != '') {
                        $this->db->set('horario_preferencia', $turno_preferencia);
                    }
                    $this->db->set('data_atualizacao', $horario);
                    $this->db->set('operador_atualizacao', $operador_id);
                    $this->db->where('ambulatorio_orcamento_item_id', $orcamento_item_id);
                    $this->db->update('tb_ambulatorio_orcamento_item');
                }
            }


            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            }
            return 1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarorcamentoitemrecepcaoagrupador($ambulatorio_orcamento_id, $paciente_id, $procedimento_convenio_id, $quantidade_agrupador, $valor) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $procedimento_convenio_id);
            if ($_POST['ajustevalor1'] != '') {
                $this->db->set('valor_ajustado', $_POST['ajustevalor1']);
            }
            $this->db->set('valor', $valor);
            $valortotal = $valor * $quantidade_agrupador;
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $quantidade_agrupador);
//            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $_POST['empresa1']);
            if (isset($_POST['observacao'])) {
                $this->db->set('observacao', $_POST['observacao']);
            }

            $this->db->set('orcamento_id', $ambulatorio_orcamento_id);

            if ($_POST['formapamento'] != '') {
                $this->db->set('forma_pagamento', $_POST['formapamento']);
            }

            if ($_POST['txtdata'] != '') {
                $this->db->set('data_preferencia', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['txtdata']))));
            }
//            $this->db->set('turno_prefencia', $_POST['turno_preferencia']);
            if ($_POST['turno_preferencia'] != '') {
                $this->db->set('horario_preferencia', $_POST['turno_preferencia']);
            }


            $this->db->set('paciente_id', $paciente_id);
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

    function gravarorcamentoitemrecepcaoagrupadormultiplo($ambulatorio_orcamento_id, $paciente_id, $procedimento_convenio_id, $quantidade_agrupador, $valor) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $procedimento_convenio_id);
            // if ($_POST['ajustevalor1'] != '') {
            //     $this->db->set('valor_ajustado', $_POST['ajustevalor1']);
            // }
            $this->db->set('valor', $valor);
            $valortotal = $valor * $quantidade_agrupador;
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $quantidade_agrupador);
//            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $_POST['empresa1']);
            // if (isset($_POST['observacao'])) {
            //     $this->db->set('observacao', $_POST['observacao']);
            // }

            $this->db->set('orcamento_id', $ambulatorio_orcamento_id);

            // if ($_POST['formapamento'] != '') {
            //     $this->db->set('forma_pagamento', $_POST['formapamento']);
            // }
            // if ($_POST['txtdata'] != '') {
            //     $this->db->set('data_preferencia', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['txtdata']))));
            // }
//            $this->db->set('turno_prefencia', $_POST['turno_preferencia']);
            // if ($_POST['turno_preferencia'] != '') {
            //     $this->db->set('horario_preferencia', $_POST['turno_preferencia']);
            // }


            $this->db->set('paciente_id', $paciente_id);
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

    function gravarorcamentoitemrecepcaonaocadastro($ambulatorio_orcamento_id, $paciente_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            if ($_POST['ajustevalor1'] != '') {
                $this->db->set('valor_ajustado', $_POST['ajustevalor1']);
            }
            $this->db->set('valor', $_POST['valor1']);
            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            if (isset($_POST['observacao'])) {
                $this->db->set('observacao', $_POST['observacao']);
            }
            $this->db->set('orcamento_id', $ambulatorio_orcamento_id);

            if ($_POST['formapamento'] != '') {
                $this->db->set('forma_pagamento', $_POST['formapamento']);
            }
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('dia_semana_preferencia', $_POST['dia_preferencia']);
            $this->db->set('turno_prefencia', $_POST['turno_preferencia']);
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

    function gravarorcamentoitem($ambulatorio_orcamento_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);

            if ($_POST['formapamento'] != '') {
                $this->db->set('forma_pagamento', $_POST['formapamento']);
            }
            if ($_POST['ajustevalor1'] != '') {
                $this->db->set('valor_ajustado', $_POST['ajustevalor1']);
            }

//            $this->db->set('dia_semana_preferencia', $_POST['dia_preferencia']);

            if ($_POST['txtdata'] != '') {
                $this->db->set('data_preferencia', date("Y-m-d", strtotime(str_replace("/", "-", $_POST['txtdata']))));
            }
            if ($_POST['turno_preferencia'] != '') {
                $this->db->set('horario_preferencia', $_POST['turno_preferencia']);
            }


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

    function gravarconsulta($ambulatorio_guia_id, $percentual, $percentual_laboratorio) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro, fidelidade_endereco_ip');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;
            $fidelidade_endereco_ip = $return[0]->fidelidade_endereco_ip;

            $this->db->select('ep.ajuste_pagamento_procedimento as ajustepagamento');
            $this->db->from('tb_empresa e');
            $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
            $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
            $this->db->orderby('e.empresa_id');
            $flags = $this->db->get()->result();

            if ($_POST['indicacao'] != "") {
                $this->db->select('mc.valor as valor_promotor, mc.percentual as percentual_promotor');
                $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
                $this->db->join('tb_procedimento_percentual_promotor m', 'm.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id', 'left');
                $this->db->where('m.procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->where('mc.promotor', $_POST['indicacao']);
                $this->db->where('mc.ativo', 'true');
//          $this->db->where('pc.ativo', 'true');
//          $this->db->where('pt.ativo', 'true');
                $return2 = $this->db->get()->result();
            } else {
                $return2 = array();
            }
//            var_dump($return2); die;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            if (count($return2) > 0) {
                $this->db->set('valor_promotor', $return2[0]->valor_promotor);
                $this->db->set('percentual_promotor', $return2[0]->percentual_promotor);
            }
            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);

            if (count($percentual_laboratorio) > 0) {
                $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
                $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
                $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
            }

            if ($_POST['medicoagenda'] != "") {
                $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                $this->db->set('medico_agenda', $_POST['medicoagenda']);
            }

            $valorProc = $_POST['valor1'];
            if (((float) $_POST['valorAjuste'] != 0)) {
                $this->db->set('procedimento_possui_ajuste_pagamento', 't');
            }

            $this->db->set('valor', $valorProc);
            $valortotal = $valorProc * $_POST['qtde1'];
            $this->db->set('valor_total', $valortotal);
//            $this->db->set('percentual_medico', $valor_percentual);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
//            $this->db->set('observacoes', $_POST['observacao']);
            if ($_POST['ordenador'] != "") {
                $this->db->set('ordenador', $_POST['ordenador']);
            }
            if ($_POST['indicacao'] != "") {
                $this->db->set('indicacao', $_POST['indicacao']);
            }
            $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
            $this->db->set('inicio', $hora);
            $this->db->set('fim', $hora);
            if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                if ($flags[0]->ajustepagamento != 't') {
                    $this->db->set('faturado', 't');
                    $this->db->set('valor1', $valortotal);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('forma_pagamento', $_POST['formapamento']);
                } else {
                    $this->db->set('forma_pagamento_ajuste', $_POST['formapamento']);
                    $this->db->set('valor_forma_pagamento_ajuste', (float) $_POST['valorAjuste']);
                }
            }
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('confirmado', 't');
            $this->db->set('tipo', 'CONSULTA');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $ambulatorio_guia_id);

            $this->db->set('paciente_id', $_POST['txtpaciente_id']);

            $this->db->set('data_faturar', $data);
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

                if ($fidelidade_endereco_ip != '') {
                    $numero_consultas = 1;
                    $tipo_grupo = $this->verificatipoprocedimento($_POST['procedimento1']);
//                        $cpf = $this->verificatipoprocedimento($procedimento_tuss_id);
                    $this->db->select('p.cpf');
                    $this->db->from('tb_paciente p');
                    $this->db->where("p.paciente_id", $_POST['txtpaciente_id']);
                    $dados_paciente = $this->db->get()->result();

//                    $this->db->select('tipo');
//                    $this->db->from('tb_agenda_exames ae');
//                    $this->db->where("agenda_exames_id", $agenda_exames_id);
//                    $exame = $this->db->get()->result();

                    $informacoes['paciente_id'] = $_POST['txtpaciente_id'];
                    $informacoes['procedimento'] = $_POST['procedimento1'];
                    $informacoes['parceiro_id'] = $_POST['convenio1'];
                    $informacoes['cpf'] = @$dados_paciente[0]->cpf;
                    $informacoes['grupo'] = $tipo_grupo;
                    $informacoes['agenda_exames_id'] = $agenda_exames_id;
                    $informacoes['numero_consultas'] = $numero_consultas;
                    $informacoes['valor'] = $_POST['valor1'];

                    $fidelidade = $this->autorizarpacientefidelidade($fidelidade_endereco_ip, $informacoes);
                    if ($fidelidade == 'pending' || $fidelidade == 'no_exists') { // Caso esteja com pagamento pendente
                        $this->db->where('agenda_exames_id', $agenda_exames_id);
                        $this->db->delete('tb_agenda_exames');

                        return array(
                            "cod" => -1,
                            "message" => $fidelidade
                        );
                    }

                    if ($fidelidade == 'true') {
                        $fidelidade_liberado = true;
                    } elseif ($fidelidade == 'false') {
                        $fidelidade_liberado = false;
                    } else {
                        $fidelidade_liberado = false;
                    }
                } else {
                    $fidelidade_liberado = false;
                }


                if ($fidelidade_liberado) {
                    $this->db->set('valor', 0);
                    $this->db->set('valor_total', $valortotal);
                } else {
                    $this->db->set('valor', $valorProc);
                    $this->db->set('valor_total', $valortotal);
                }

                if ($fidelidade_liberado) {
                    $this->db->set('faturado', 't');
//                        $this->db->set('forma_pagamento', $formapagamento);
                    $this->db->set('valor1', 0);
//                        $this->db->set('valor_total', $valor);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('data_faturamento', $horario);
                } elseif ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                    if ($flags[0]->ajustepagamento != 't') {
                        $this->db->set('faturado', 't');
                        $this->db->set('valor1', $valortotal);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                        $this->db->set('forma_pagamento', $_POST['formapamento']);
                    } else {
                        $this->db->set('forma_pagamento_ajuste', $_POST['formapamento']);
                        $this->db->set('valor_forma_pagamento_ajuste', (float) $_POST['valorAjuste']);
                    }
                }


                $this->db->set('senha', md5($agenda_exames_id));
                $this->db->where('agenda_exames_id', $agenda_exames_id);
                $this->db->update('tb_agenda_exames');


                $this->db->select('ep.autorizar_sala_espera');
                $this->db->from('tb_empresa e');
                $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
                $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
                $this->db->orderby('e.empresa_id');
                $sala_de_espera_p = $this->db->get()->result();

                if (@$sala_de_espera_p[0]->autorizar_sala_espera == 'f') {

                    $tipo_grupo = $this->verificatipoprocedimento($_POST['procedimento1']);
                    $dados['agenda_exames_id'] = $agenda_exames_id;
                    $dados['medico'] = $_POST['medicoagenda'];
                    $dados['paciente_id'] = $_POST['txtpaciente_id'];
                    $dados['procedimento_tuss_id'] = $_POST['procedimento1'];
                    $dados['sala_id'] = $_POST['sala1'];
                    $dados['guia_id'] = $ambulatorio_guia_id;
                    $dados['tipo'] = $tipo_grupo;

                    $this->enviarsaladeespera($dados);
                }
            }

            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarprocedimentoaso($gravarempresa, $ambulatorio_guia_id, $aso_id) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            $this->db->select('ep.ajuste_pagamento_procedimento as ajustepagamento');
            $this->db->from('tb_empresa e');
            $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
            $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
            $this->db->orderby('e.empresa_id');
            $flags = $this->db->get()->result();


            $this->db->select('pc.valortotal, pc.procedimento_convenio_id');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
            $this->db->where('pt.tipo_aso', $_POST['tipo']);
            $this->db->where('pc.ativo', 't');
            if ($_POST['consulta'] == "particular") {
                $this->db->where('pc.convenio_id', $gravarempresa);
            } else {
                $this->db->where('pc.convenio_id', $_POST['convenio1']);
            }
            $this->db->where('pt.grupo', 'ASO');
            $result = $this->db->get()->result();
//            var_dump($result);die; 
            if (count($result) > 0) {
                $valoraso = $result[0]->valortotal;
                $procedimento_convenio_id = $result[0]->procedimento_convenio_id;
                $valortotal = $valoraso;
            }

            if (count($result) > 0) {
                $procedimentopercentual = $procedimento_convenio_id;
            } else {
                return -1;
            }
            if ($_POST['medico'] != "") {
                $medicopercentual = $_POST['medico'];
//            var_dump($_POST['medico']);die;            
                $percentual = $this->percentualmedicoconvenioexames($procedimentopercentual, $medicopercentual);
                if (count($percentual) == 0) {
                    $percentual = $this->percentualmedicoprocedimento($procedimentopercentual, $medicopercentual);
//                var_dump($percentual);die;
                }
            }

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $this->db->set('valor', $valoraso);
            $this->db->set('valor_total', $valortotal);
            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
            $this->db->set('procedimento_tuss_id', $procedimento_convenio_id); //procedimento_tuss_id na tabela de agenda exames é o procedimento_convenio_id

            $percentual_laboratorio = $this->percentuallaboratorioconvenioexames($procedimento_convenio_id);

            if (count($percentual_laboratorio) > 0) {
                $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
                $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
                $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
            }

            if ($_POST['medico'] != "") {
                $this->db->set('medico_consulta_id', $_POST['medico']);
                $this->db->set('medico_agenda', $_POST['medico']);
            }

//            var_dump($_POST['cadastro_aso_id']);die;
            if (!$_POST['cadastro_aso_id'] > 0) {
                $this->db->set('quantidade', 1);
                $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
                $this->db->set('inicio', $hora);
                $this->db->set('fim', $hora);
                $this->db->set('ordenador', 1);
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('confirmado', 't');
                $this->db->set('tipo', 'EXAME');
                $this->db->set('ativo', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('guia_id', $ambulatorio_guia_id);

                $this->db->set('paciente_id', $_POST['txtPacienteId']);

                $this->db->set('data_faturar', $data);
                $this->db->set('data', $_POST['data_realizacao']);
                $this->db->set('data_autorizacao', $horario);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('aso_id', $aso_id);
                $this->db->set('cadastro_aso_id', $aso_id);
                $this->db->set('operador_autorizacao', $operador_id);
                $this->db->insert('tb_agenda_exames');
            } else {
                $this->db->select('ae.agenda_exames_id');
                $this->db->from('tb_agenda_exames ae');
                $this->db->where('ae.aso_id', $_POST['cadastro_aso_id']);
                $pesquisa = $this->db->get()->result();
//                var_dump($pesquisa[0]->agenda_exames_id);die;
                $this->db->set('quantidade', 1);
                $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
                $this->db->set('inicio', $hora);
                $this->db->set('fim', $hora);
                $this->db->set('ordenador', 1);
                $empresa_id = $this->session->userdata('empresa_id');
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('confirmado', 't');
                $this->db->set('tipo', 'EXAME');
                $this->db->set('ativo', 'f');
                $this->db->set('situacao', 'OK');
//                $this->db->set('guia_id', $ambulatorio_guia_id);
                $this->db->set('paciente_id', $_POST['txtPacienteId']);
                $this->db->set('data_faturar', $data);
                $this->db->set('data', $_POST['data_realizacao']);
                $this->db->set('data_autorizacao', $horario);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->set('operador_autorizacao', $operador_id);
                $this->db->set('aso_id', $aso_id);
                $this->db->set('cadastro_aso_id', $aso_id);
                $this->db->where('guia_id', $ambulatorio_guia_id);
                $this->db->where('agenda_exames_id', $pesquisa[0]->agenda_exames_id);
                $this->db->update('tb_agenda_exames');
            }
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return -1;
            } else {
                // Caso edite o aso, ele não tenta gravar de novo na agenda exames, já que está gravado
                // Além do fato de que ao dar update não se tem um Insert_id, fazendo com que o sistema tenha uma parada
                if (!$_POST['cadastro_aso_id'] > 0) {
                    $agenda_exames_id = $this->db->insert_id();
                    // var_dump($agenda_exames_id);
                    // die;

                    $this->db->set('senha', md5($agenda_exames_id));
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');


                    $this->db->select('ep.autorizar_sala_espera');
                    $this->db->from('tb_empresa e');
                    $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
                    $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
                    $this->db->orderby('e.empresa_id');
                    $sala_de_espera_p = $this->db->get()->result();

                    if (@$sala_de_espera_p[0]->autorizar_sala_espera == 'f') {

                        $tipo_grupo = $this->verificatipoprocedimento($procedimento_convenio_id);
                        $dados['agenda_exames_id'] = $agenda_exames_id;
                        $dados['medico'] = $_POST['medico'];
                        $dados['paciente_id'] = $_POST['txtPacienteId'];
                        $dados['procedimento_tuss_id'] = $procedimento_convenio_id;
                        $dados['sala_id'] = $_POST['sala1'];
                        $dados['guia_id'] = $ambulatorio_guia_id;
                        $dados['tipo'] = 'CONSULTA';

                        $this->enviarsaladeespera($dados);
                    }
                }
            }

            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsultaaso($ambulatorio_guia_id, $percentual, $percentual_laboratorio, $procedimento_convenio_id, $gravarempresa, $retorno) {
        try {
//            var_dump($percentual_laboratorio);die;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('ep.ajuste_pagamento_procedimento as ajustepagamento');
            $this->db->from('tb_empresa e');
            $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
            $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
            $this->db->orderby('e.empresa_id');
            $flags = $this->db->get()->result();

            $this->db->select('pc.procedimento_tuss_id');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->where('pc.procedimento_convenio_id', $procedimento_convenio_id);
            $procedimento_tuss = $this->db->get()->result();
            $proc_tuss = $procedimento_tuss[0]->procedimento_tuss_id;

            $this->db->select('pc.valortotal, pc.procedimento_convenio_id');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->where('pc.procedimento_tuss_id', $proc_tuss);
            $this->db->where('pc.ativo', 't');
            if ($_POST['consulta'] == "particular") {
                $this->db->where('pc.convenio_id', $gravarempresa);
            } else {
                $this->db->where('pc.convenio_id', $_POST['convenio1']);
            }
            $return = $this->db->get()->result();
            $valorproc = $return[0]->valortotal;
            $procedimento_convenio_id_novo = $return[0]->procedimento_convenio_id;

//            var_dump($percentual);die;

            $hora = date("H:i:s");
            $data = date("Y-m-d");

            $this->db->set('cadastro_aso_id', $retorno);
            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
            $this->db->set('procedimento_tuss_id', $procedimento_convenio_id_novo); //procedimento_tuss_id na tabela de agenda exames é o procedimento_convenio_id

            if (count($percentual_laboratorio) > 0) {
                $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
                $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
                $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
            }

            if ($_POST['medico'] != "") {
                $this->db->set('medico_consulta_id', $_POST['medico']);
                $this->db->set('medico_agenda', $_POST['medico']);
            }

            $valorProc = $valorproc;

//            var_dump($valorProc);die;

            $this->db->set('valor', $valorProc);
            $valortotal = $valorProc;
            $this->db->set('valor_total', $valortotal);

            $this->db->set('quantidade', 1);
            if (isset($_POST['autorizacao1'])) {
                $this->db->set('autorizacao', $_POST['autorizacao1']);
            }
            $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
            $this->db->set('inicio', $hora);
            $this->db->set('fim', $hora);
            $this->db->set('ordenador', 1);
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('confirmado', 't');
            $this->db->set('tipo', 'EXAME');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $ambulatorio_guia_id);

            $this->db->set('paciente_id', $_POST['txtPacienteId']);

            $this->db->set('data_faturar', $data);
            $this->db->set('data', $_POST['data_realizacao']);
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


                $this->db->select('ep.autorizar_sala_espera');
                $this->db->from('tb_empresa e');
                $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
                $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
                $this->db->orderby('e.empresa_id');
                $sala_de_espera_p = $this->db->get()->result();

                if (@$sala_de_espera_p[0]->autorizar_sala_espera == 'f') {

                    $tipo_grupo = $this->verificatipoprocedimento($procedimento_convenio_id_novo);
                    $dados['agenda_exames_id'] = $agenda_exames_id;
                    $dados['medico'] = $_POST['medico'];
                    $dados['paciente_id'] = $_POST['txtpaciente_id'];
                    $dados['procedimento_tuss_id'] = $procedimento_convenio_id_novo;
                    $dados['sala_id'] = $_POST['sala1'];
                    $dados['guia_id'] = $ambulatorio_guia_id;
                    $dados['tipo'] = $tipo_grupo;

                    $this->enviarsaladeespera($dados);
                }
            }

            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarconsultaagrupador($ambulatorio_guia_id, $agrupador_id, $procedimento, $valor, $valor_diferenciado, $percentual, $percentual_laboratorio, $grupo, $quantidade = 1) {
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;


            if ($_POST['indicacao'] != "") {
                $this->db->select('mc.valor as valor_promotor, mc.percentual as percentual_promotor');
                $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
                $this->db->join('tb_procedimento_percentual_promotor m', 'm.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id', 'left');
                $this->db->where('m.procedimento_tuss_id', $procedimento);
                $this->db->where('mc.promotor', $_POST['indicacao']);
                $this->db->where('mc.ativo', 'true');
//          $this->db->where('pc.ativo', 'true');
//          $this->db->where('pt.ativo', 'true');
                $return2 = $this->db->get()->result();
            } else {
                $return2 = array();
            }
//            var_dump($return2); die;

            $hora = date("H:i:s");
            $data = date("Y-m-d");
            if (count($return2) > 0) {
                $this->db->set('valor_promotor', $return2[0]->valor_promotor);
                $this->db->set('percentual_promotor', $return2[0]->percentual_promotor);
            }
            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
            $this->db->set('procedimento_tuss_id', $procedimento);

            if (count($percentual_laboratorio) > 0) {
                $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
                $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
                $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
            }

            if ($_POST['medicoagenda'] != "") {
                $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                $this->db->set('medico_agenda', $_POST['medicoagenda']);
            }
            $this->db->set('valor', $valor);
//            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor_total', $valor);
//            $this->db->set('percentual_medico', $valor_percentual);
            $this->db->set('quantidade', 1);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
//            $this->db->set('observacoes', $_POST['observacao']);
            if ($_POST['ordenador'] != "") {
                $this->db->set('ordenador', $_POST['ordenador']);
            }
            if ($_POST['indicacao'] != "") {
                $this->db->set('indicacao', $_POST['indicacao']);
            }
            $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
            $this->db->set('inicio', $hora);
            $this->db->set('fim', $hora);
            if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                $this->db->set('faturado', 't');
                $this->db->set('valor1', $valor);
                $this->db->set('operador_faturamento', $operador_id);
                $this->db->set('data_faturamento', $horario);
                $this->db->set('forma_pagamento', $_POST['formapamento']);
            }
            $empresa_id = $this->session->userdata('empresa_id');
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('confirmado', 't');
            $this->db->set('ativo', 'f');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $ambulatorio_guia_id);

            $this->db->set('tipo', $grupo);
            $this->db->set('agrupador_pacote_id', $agrupador_id);
            $this->db->set('pacote_diferenciado', $valor_diferenciado);

            $this->db->set('paciente_id', $_POST['txtpaciente_id']);

            $this->db->set('data_faturar', $data);
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

    function gravarfisioterapia($ambulatorio_guia_id, $percentual, $medico_id, $percentual_laboratorio) {
        try {
//            var_dump($percentual); die;
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->select('dinheiro, fidelidade_endereco_ip');
            $this->db->from('tb_convenio');
            $this->db->where("convenio_id", $_POST['convenio1']);
            $query = $this->db->get();
            $return = $query->result();
            $dinheiro = $return[0]->dinheiro;
            $fidelidade_endereco_ip = $return[0]->fidelidade_endereco_ip;

            $this->db->select('ep.ajuste_pagamento_procedimento as ajustepagamento');
            $this->db->from('tb_empresa e');
            $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
            $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
            $this->db->orderby('e.empresa_id');
            $flags = $this->db->get()->result();
//            var_dump($_POST['homecare']); die;
//            if ((isset($_POST['indicacao']) && isset($_POST['indicacao_paciente'])) && ($_POST['indicacao'] != $_POST['indicacao_paciente'])) {
//                $this->db->set('indicacao_id', $_POST['indicacao']);
//                $this->db->where('ambulatorio_guia_id', $ambulatorio_guia_id);
//                $this->db->update('tb_ambulatorio_guia');
//            }
            $hora = date("H:i:s");
            if ($_POST['data_homecare'] != '') {
                $data = date("Y-m-d", strtotime(str_replace("/", "-", $_POST['data_homecare'])));
            } else {
                $data = date("Y-m-d");
            }
//            var_dump($data); die;

            $qtde = $_POST['qtde'];
            for ($index = 1; $index <= $qtde; $index++) {
                if ($_POST['indicacao'] != "") {
                    $this->db->select('mc.valor as valor_promotor, mc.percentual as percentual_promotor');
                    $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
                    $this->db->join('tb_procedimento_percentual_promotor m', 'm.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id', 'left');
                    $this->db->where('m.procedimento_tuss_id', $_POST['procedimento1']);
                    $this->db->where('mc.promotor', $_POST['indicacao']);
                    $this->db->where('mc.ativo', 'true');
//          $this->db->where('pc.ativo', 'true');
//          $this->db->where('pt.ativo', 'true');
                    $return2 = $this->db->get()->result();
                } else {
                    $return2 = array();
                }
//            var_dump($return2); die;

                $hora = date("H:i:s");
                $data = date("Y-m-d");
                if (count($percentual_laboratorio) > 0) {
                    $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
                    $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
                    $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
                }

                $this->db->set('valor_medico', $percentual[0]->perc_medico);
                $this->db->set('percentual_medico', $percentual[0]->percentual);
                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
                if ($_POST['medicoagenda'] != "") {
                    $this->db->set('medico_consulta_id', $_POST['medicoagenda']);
                    $this->db->set('medico_agenda', $_POST['medicoagenda']);
                }
                $this->db->set('convenio_id', $_POST['convenio1']);
                $this->db->set('quantidade', '1');
                if ($index == 1) {
                    if (count($return2) > 0) {
//                        var_dump($index, $_POST['indicacao']);
                        $this->db->set('valor_promotor', $return2[0]->valor_promotor);
                        $this->db->set('percentual_promotor', $return2[0]->percentual_promotor);
                        $this->db->set('indicacao', $_POST['indicacao']);
                    }
                }
//              var_dump($_POST['indicacao']);
//               die;
                $sessao2_valor = $this->listarprocedimentoconveniosessao($_POST['procedimento1'], $index);
//                if(){
//                    
//                }
                $valor_convenio = $_POST['valor1'] / $qtde;
                if (count($sessao2_valor) > 0) {
                    $valor = $sessao2_valor[0]->valor_sessao;
                } else {
                    if ($index == 1) {
//                        $valor = $_POST['valor1'];
                        $valor = $_POST['valor1'];
                    } else {
                        $valor = 0;
                    }
                }

                if (((float) $_POST['valorAjuste'] != 0)) {
                    $this->db->set('procedimento_possui_ajuste_pagamento', 't');
                }

                if ($dinheiro == "t") {
                    if ($index == 1 && $_POST['homecare'] != 't') {
                        $this->db->set('valor', $valor);
//                        $this->db->set('percentual_medico', $valor_percentual);
                        $this->db->set('valor_total', $valor);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $valor);
                        $this->db->set('valor_total', $valor);
                        $this->db->set('confirmado', 'f');
                    }
                } else {
                    if ($index == 1 && $_POST['homecare'] != 't') {
                        $this->db->set('valor', $valor_convenio);
                        $this->db->set('valor_total', $valor_convenio);
                        $this->db->set('confirmado', 't');
                    } else {
                        $this->db->set('valor', $valor_convenio);
                        $this->db->set('valor_total', $valor_convenio);
                        $this->db->set('confirmado', 'f');
                    }
                }
                $this->db->set('autorizacao', $_POST['autorizacao1']);
                if ($_POST['ordenador'] != "") {
                    $this->db->set('ordenador', $_POST['ordenador']);
                }
                $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
                $this->db->set('inicio', $hora);
                $this->db->set('fim', $hora);
                if ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                    if ($flags[0]->ajustepagamento != 't') {
                        $this->db->set('faturado', 't');
                        if ($index == 1) {
                            $this->db->set('valor1', $_POST['valor1']);
                        } else {
                            $this->db->set('valor1', 0);
                        }
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                        $this->db->set('forma_pagamento', $_POST['formapamento']);
                    } else {
                        $this->db->set('forma_pagamento_ajuste', $_POST['formapamento']);
                        $this->db->set('valor_forma_pagamento_ajuste', (float) $_POST['valorAjuste']);
                    }
                }
                if ($_POST['indicacao'] != "") {
                    $this->db->set('indicacao', $_POST['indicacao']);
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

                $this->db->set('medico_solicitante', $medico_id);
                $this->db->set('data_faturar', $data);
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

                    if ($fidelidade_endereco_ip != '' && $index == 1) {
                        $numero_consultas = 1;
                        $tipo_grupo = $this->verificatipoprocedimento($_POST['procedimento1']);
//                        $cpf = $this->verificatipoprocedimento($procedimento_tuss_id);
                        $this->db->select('p.cpf');
                        $this->db->from('tb_paciente p');
                        $this->db->where("p.paciente_id", $_POST['txtpaciente_id']);
                        $dados_paciente = $this->db->get()->result();




                        $informacoes['paciente_id'] = $_POST['txtpaciente_id'];
                        $informacoes['procedimento'] = $_POST['procedimento1'];
                        $informacoes['parceiro_id'] = $_POST['convenio1'];
                        $informacoes['cpf'] = @$dados_paciente[0]->cpf;
                        $informacoes['grupo'] = $tipo_grupo;
                        $informacoes['agenda_exames_id'] = $agenda_exames_id;
                        $informacoes['numero_consultas'] = $numero_consultas;
                        $informacoes['valor'] = $_POST['valor1'];

                        $fidelidade = $this->autorizarpacientefidelidade($fidelidade_endereco_ip, $informacoes);
                        if ($fidelidade == 'pending' || $fidelidade == 'no_exists') { // Caso esteja com pagamento pendente
                            $this->db->where('agenda_exames_id', $agenda_exames_id);
                            $this->db->delete('tb_agenda_exames');

                            return array(
                                "cod" => -1,
                                "message" => $fidelidade
                            );
                        }
//                        var_dump($fidelidade);
//                        die;
                        if ($fidelidade == 'true') {
                            $fidelidade_liberado = true;
                        } elseif ($fidelidade == 'false') {
                            $fidelidade_liberado = false;
                        } else {
                            $fidelidade_liberado = false;
                        }
                    } else {
                        $fidelidade_liberado = false;
                    }


                    if ($fidelidade_liberado) {
                        $this->db->set('valor', 0);
                        $this->db->set('valor_total', $valor);
                    } else {
                        $this->db->set('valor', $_POST['valor1']);
                        $this->db->set('valor_total', $valor);
                    }

                    if ($fidelidade_liberado) {
                        $this->db->set('faturado', 't');
//                        $this->db->set('forma_pagamento', $formapagamento);
                        $this->db->set('valor1', 0);
//                        $this->db->set('valor_total', $valor);
                        $this->db->set('operador_faturamento', $operador_id);
                        $this->db->set('data_faturamento', $horario);
                    } elseif ($_POST['formapamento'] != 0 && $dinheiro == "t") {
                        if ($flags[0]->ajustepagamento != 't') {
                            $this->db->set('faturado', 't');
                            if ($index == 1) {
                                $this->db->set('valor1', $_POST['valor1']);
                            } else {
                                $this->db->set('valor1', 0);
                            }
                            $this->db->set('operador_faturamento', $operador_id);
                            $this->db->set('data_faturamento', $horario);
                            $this->db->set('forma_pagamento', $_POST['formapamento']);
                        } else {
                            $this->db->set('forma_pagamento_ajuste', $_POST['formapamento']);
                            $this->db->set('valor_forma_pagamento_ajuste', (float) $_POST['valorAjuste']);
                        }
                    }

                    $this->db->set('senha', md5($agenda_exames_id));
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');




                    $this->db->select('ep.autorizar_sala_espera');
                    $this->db->from('tb_empresa e');
                    $this->db->where('e.empresa_id', $this->session->userdata('empresa_id'));
                    $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
                    $this->db->orderby('e.empresa_id');
                    $sala_de_espera_p = $this->db->get()->result();

                    if (@$sala_de_espera_p[0]->autorizar_sala_espera == 'f' && $index == 1) {

                        $tipo_grupo = $this->verificatipoprocedimento($_POST['procedimento1']);
                        $dados['agenda_exames_id'] = $agenda_exames_id;
                        $dados['medico'] = $_POST['medicoagenda'];
                        $dados['paciente_id'] = $_POST['txtpaciente_id'];
                        $dados['procedimento_tuss_id'] = $_POST['procedimento1'];
                        $dados['sala_id'] = $_POST['sala1'];
                        $dados['guia_id'] = $ambulatorio_guia_id;
                        $dados['tipo'] = $tipo_grupo;

                        $this->enviarsaladeespera($dados);
                    }
                }
            }

            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarprocedimentoconveniosessao($convenio_id, $sessao) {

        //verifica se esse medico já está cadastrado nesse procedimento 
        $this->db->select('pc.procedimento_convenio_id, 
                            pcs.procedimento_convenio_sessao_id,
                            pcs.sessao,
                            pcs.valor_sessao');
        $this->db->from('tb_procedimento_convenio_sessao pcs');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = pcs.procedimento_convenio_id', 'left');
        $this->db->where('pcs.ativo', 't');
        $this->db->where('pcs.sessao', $sessao);
        $this->db->where('pcs.procedimento_convenio_id', $convenio_id);
        $return = $this->db->get();
        $result = $return->result();
        return $result;
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
                if ($_POST['indicacao'] != "") {
                    $this->db->set('indicacao', $_POST['indicacao']);
                }
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

            $this->db->select('ag.tipo');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
            $this->db->where('pc.procedimento_convenio_id', $_POST['procedimento1']);
            $return = $this->db->get()->result();
            $tipo = $return[0]->tipo;
//            var_dump($tipo); die;
            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            $this->db->set('valor', $_POST['valor1']);

            if ($_POST['valortot'] != "") {
                $this->db->set('valor_bruto', $_POST['valortot']);
            }

            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
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
                $this->db->set('medico_solicitante', $_POST['medicoagenda']);
            }
            $this->db->set('faturado', 't');
            $this->db->set('situacao', 'OK');
            $this->db->set('guia_id', $_POST['txtguia_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            $this->db->set('data', $_POST['txtdata']);
            $this->db->set('data_faturar', $_POST['txtdata']);
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
                $this->db->set('tipo', $tipo);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);

                $this->db->insert('tb_ambulatorio_laudo');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarexamesfaturamentomatmed() {
        try {

            $this->db->select('ag.tipo');
            $this->db->from('tb_procedimento_convenio pc');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_ambulatorio_grupo ag', 'ag.nome = pt.grupo', 'left');
            $this->db->where('pc.procedimento_convenio_id', $_POST['procedimento1']);
            $return = $this->db->get()->result();
            $tipo = $return[0]->tipo;
//            var_dump($tipo); die;
            $hora = date("H:i:s");
            $data = date("Y-m-d");
            $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
            $this->db->set('valor', $_POST['valor1']);

            if ($_POST['valortot'] != "") {
                $this->db->set('valor_bruto', $_POST['valortot']);
            }

            $valortotal = $_POST['valor1'] * $_POST['qtde1'];
            $this->db->set('valor1', $valortotal);
            $this->db->set('valor_total', $valortotal);
            $this->db->set('quantidade', $_POST['qtde1']);
            $this->db->set('autorizacao', $_POST['autorizacao1']);
            $this->db->set('guiaconvenio', $_POST['guiaconvenio']);
            $this->db->set('empresa_id', $_POST['txtempresa']);
            $this->db->set('confirmado', 't');
            $this->db->set('tipo', $tipo);
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
            $this->db->set('data_faturar', $_POST['txtdata']);
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

//            if ($_POST['laudo'] == "on") {
//                $this->db->set('empresa_id', $_POST['txtempresa']);
//                $this->db->set('data', $_POST['txtdata']);
//                $this->db->set('medico_parecer1', $_POST['medicoagenda']);
//                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
//                $this->db->set('procedimento_tuss_id', $_POST['procedimento1']);
//                $this->db->set('exame_id', $exames_id);
//                $this->db->set('guia_id', $_POST['txtguia_id']);
//                $this->db->set('tipo', $tipo);
//                $this->db->set('data_cadastro', $horario);
//                $this->db->set('operador_cadastro', $operador_id);
//
//                $this->db->insert('tb_ambulatorio_laudo');
//            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function editarexames($percentual) {
        try {
            if ($_POST['indicacao'] != "") {
                $this->db->select('mc.valor as valor_promotor, mc.percentual as percentual_promotor');
                $this->db->from('tb_procedimento_percentual_promotor_convenio mc');
                $this->db->join('tb_procedimento_percentual_promotor m', 'm.procedimento_percentual_promotor_id = mc.procedimento_percentual_promotor_id', 'left');
                $this->db->where('m.procedimento_tuss_id', $_POST['procedimento1']);
                $this->db->where('mc.promotor', $_POST['indicacao']);
                $this->db->where('mc.ativo', 'true');
                $return2 = $this->db->get()->result();
            } else {

                $return2 = array();
            }

            if (count($return2) > 0) {
                $this->db->set('valor_promotor', $return2[0]->valor_promotor);
                $this->db->set('percentual_promotor', $return2[0]->percentual_promotor);
            }

            $this->db->set('autorizacao', $_POST['autorizacao1']);
            $this->db->set('agenda_exames_nome_id', $_POST['sala1']);
            $this->db->set('guia_id', $_POST['guia_id']);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $perfil_id = $this->session->userdata('perfil_id');
//            var_dump($_POST['medico']);die;
            $this->db->set('paciente_id', $_POST['txtpaciente_id']);
            if ($_POST['medico'] != '') {
                $this->db->set('medico_solicitante', $_POST['medico']);
            }
            if ($_POST['indicacao'] != '') {
                $this->db->set('indicacao', $_POST['indicacao']);
            }
            if (isset($_POST['data'])) {
                $this->db->set('data', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data']))));
            }
            if (isset($_POST['data_faturar'])) {
                $this->db->set('data_faturar', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_faturar']))));
            }
            if (isset($_POST['data_entrega'])) {
                $this->db->set('data_entrega', date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_entrega']))));
            }

            $this->db->set('medico_agenda', $_POST['medico_agenda']);
            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
            $this->db->set('data_editar', $horario);
            $this->db->set('operador_editar', $operador_id);
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_agenda_exames');

            $this->db->set('sala_id', $_POST['sala1']);
            $this->db->where('agenda_exames_id', $_POST['agenda_exames_id']);
            $this->db->update('tb_exames');

            if (isset($_POST['data_producao'])) {
                $data_prod = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_producao'])));

                $this->db->select('al.ambulatorio_laudo_id');
                $this->db->from('tb_ambulatorio_laudo al');
                $this->db->join('tb_exames e', 'al.exame_id = e.exames_id', 'left');
                $this->db->where('e.agenda_exames_id', $_POST['agenda_exames_id']);
                $query = $this->db->get()->result();

                if (count($query) > 0) {
                    if($perfil_id == 1){
                        $this->db->set('medico_parecer1', $_POST['medico_agenda']);
                    }
                    $this->db->set('data_producao', $data_prod);
                    $this->db->set('data_alteracao_producao', $horario);
                    $this->db->where('ambulatorio_laudo_id', $query[0]->ambulatorio_laudo_id);
                    $this->db->update('tb_ambulatorio_laudo');
                }
            }

            if (isset($_POST['data_laudo'])) {
                $data_laudo = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['data_laudo'])));

                $this->db->select('al.ambulatorio_laudo_id');
                $this->db->from('tb_ambulatorio_laudo al');
                $this->db->join('tb_exames e', 'al.exame_id = e.exames_id', 'left');
                $this->db->where('e.agenda_exames_id', $_POST['agenda_exames_id']);
                $query = $this->db->get()->result();

                if (count($query) > 0) {
                    $this->db->set('data', $data_laudo);
                    $this->db->where('ambulatorio_laudo_id', $query[0]->ambulatorio_laudo_id);
                    $this->db->update('tb_ambulatorio_laudo');
                }
            }
//            
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
                              ae.data_entrega,
                              ae.data,
                              ae.data_faturar,
                              al.data as data_laudo,
                              al.data_producao,
                              ae.medico_agenda,
                              ae.procedimento_tuss_id,
                              ae.agenda_exames_nome_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->where("ae.agenda_exames_id", $ambulatorio_guia_id);
        $query = $this->db->get();
        return $query->result();
    }

    function valorexamesfaturamento() {
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

    function valorexames($percentual, $percentual_laboratorio) {
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

            if (count($percentual_laboratorio) > 0) {
                $this->db->set('valor_laboratorio', $percentual_laboratorio[0]->perc_laboratorio);
                $this->db->set('percentual_laboratorio', $percentual_laboratorio[0]->percentual);
                $this->db->set('laboratorio_id', $percentual_laboratorio[0]->laboratorio);
            }

            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
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

    function listardadosantigoseditarvalor($agenda_exames_id) {
//            echo 'model asdasdasdas'. '<br>';
//            var_dump($agenda_exames_id); die;
        $data = date("Y-m-d");
        $horario = date("Y-m-d H:i:s");
        $empresa_id = $this->session->userdata('empresa_id');
        $operador_id = $this->session->userdata('operador_id');
        $this->db->select('ae.agenda_exames_id,
                            
                            ae.valor_total,
                            ae.valor,
                            ae.procedimento_tuss_id,
                            ae.forma_pagamento,
                            ae.valor1,
                            ae.forma_pagamento2,
                            ae.valor2,
                            ae.forma_pagamento3,
                            ae.valor3,
                            ae.forma_pagamento4,
                            ae.valor4

                            ');
        $this->db->from('tb_agenda_exames ae');
        $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
//        echo '<pre>';
        $return = $this->db->get()->result();
//        var_dump($return);


        $this->db->set('valor_total', $return[0]->valor_total);
        $this->db->set('valor', $return[0]->valor);
        $this->db->set('procedimento_convenio_id', $return[0]->procedimento_tuss_id);
        $this->db->set('forma_pagamento', $return[0]->forma_pagamento);
        $this->db->set('valor1', $return[0]->valor1);
        $this->db->set('forma_pagamento2', $return[0]->forma_pagamento2);
        $this->db->set('valor2', $return[0]->valor2);
        $this->db->set('forma_pagamento3', $return[0]->forma_pagamento3);
        $this->db->set('valor3', $return[0]->valor3);
        $this->db->set('forma_pagamento4', $return[0]->forma_pagamento4);
        $this->db->set('valor4', $return[0]->valor4);
        $this->db->set('agenda_exames_id', $return[0]->agenda_exames_id);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->set('data_cadastro', $horario);
        $this->db->insert('tb_agenda_exames_valor');


//        die;
//        return $return;
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
                $p21 = $_POST['p21'];
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
                     xmlelement ( name  p20 , '$p20'),
                     xmlelement ( name  p21 , '$p21')
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
