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
                            o2.nome as medico_solicitante,
                            sc.situacao');
        $this->db->from('tb_solicitacao_cirurgia sc');

        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_agendado', 'left');
        $this->db->join('tb_operador o2', 'o2.operador_id = sc.medico_solicitante', 'left');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->where('sc.autorizado', 'f');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listarsolicitacoes3($solicitacao_id) {

        $this->db->select(' p.paciente_id,
                            p.nome,
                            sc.solicitacao_cirurgia_id,
                            sc.data_prevista,
                            sc.orcamento,
                            sc.fornecedor_id,
                            c.nome as convenio,
                            c.convenio_id,
                            o.nome as medico,
                            sc.situacao');
        $this->db->from('tb_solicitacao_cirurgia sc');
//        $this->db->where('sc.ativo', 't');
//        $this->db->where('sc.excluido', 'f');
//        $this->db->where('sc.autorizado', 'f');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_solicitante', 'left');

        return $this->db->get()->result();
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

    function listarfornecedormaterial($args = array()) {

        $this->db->select('fornecedor_material_id, 
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
        $this->db->from('tb_fornecedor_material f');
        $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
        $this->db->where('f.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('f.nome ilike', $args['nome'] . "%", 'left');
            }
        }
        return $this->db;
    }

    function listarlaudosolicitacaocirurgica($laudo_id) {
        $this->db->select('medico_parecer1, 
                           p.nome,
                           p.paciente_id');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->join('tb_paciente p', 'p.paciente_id = al.paciente_id', 'left');
        $this->db->where('al.ambulatorio_laudo_id', $laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarpacientesolicitacaocirurgicainternacao($paciente_id) {
        $this->db->select('
                           p.nome,
                           p.leito,
                           p.paciente_id');
        $this->db->from('tb_paciente p');
        $this->db->where('paciente_id', $paciente_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarfuncaoexameequipe($guia_id) {

        $this->db->select('funcao');
        $this->db->from('tb_agenda_exame_equipe');
        $this->db->where('funcao', $_POST['funcao']);
        $this->db->where('guia_id', $guia_id);
        $this->db->where('ativo', 't');
        $query = $this->db->get();
        $return = $query->result();
        return $return;
    }

    function gravarguiacirurgicaequipeeditar($procedimentos, $guia, $solicitacao_id) {
//        var_dump($procedimentos); die;
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
//        var_dump($guia); die;
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

            if ($procedimentos[$i]->horario_especial == 't') {
                $valProcedimento = ($valor) + ($valor * $horario_especial);
            } else {
                $valProcedimento = $valor;
            }
//            var_dump($valProcedimento); die;
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
                $this->db->where("funcao", $_POST['funcao']);
                $query = $this->db->get();
                $return2 = $query->result();
                $val = number_format($valMedico * ($return2[0]->valor / 100), 2, '.', '');
            }

//            echo "<pre>";
//            var_dump($val); echo "<hr>";
//            die;

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('operador_responsavel', $_POST['medico']);
            $this->db->set('agenda_exames_id', $procedimentos[$i]->agenda_exames_id);
            $this->db->set('valor', $val);
            $this->db->set('guia_id', $guia->ambulatorio_guia_id);
            $this->db->set('funcao', $_POST['funcao']);
            $this->db->insert('tb_agenda_exame_equipe');

            $this->db->set('funcao', $_POST['funcao']);
            $this->db->set('operador_responsavel', $_POST['medico']);
            $this->db->set('solicitacao_cirurgia_id', $solicitacao_id);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_equipe_cirurgia_operadores');
        }
//        die;
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
//        var_dump($guia); die;
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

            if ($procedimentos[$i]->horario_especial == 't') {
                $valProcedimento = ($valor) + ($valor * $horario_especial);
            } else {
                $valProcedimento = $valor;
            }
//            var_dump($valProcedimento); die;
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
                $this->db->where("funcao", $_POST['funcao']);
                $query = $this->db->get();
                $return2 = $query->result();
                $val = number_format($valMedico * ($return2[0]->valor / 100), 2, '.', '');
            }

//            echo "<pre>";
//            var_dump($val); echo "<hr>";
//            die;

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('operador_responsavel', $_POST['medico']);
            $this->db->set('agenda_exames_id', $procedimentos[$i]->agenda_exames_id);
            $this->db->set('valor', $val);
            $this->db->set('guia_id', $guia->ambulatorio_guia_id);
            $this->db->set('funcao', $_POST['funcao']);
            $this->db->insert('tb_agenda_exame_equipe');
        }
//        die;
    }

    function listarhospitaissolicitacao() {
        $this->db->select('hospital_id, 
                               f.nome');
        $this->db->from('tb_hospital f');
        $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
        $this->db->where('f.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarfornecedorsolicitacao() {
        $this->db->select('fornecedor_material_id, 
                               f.nome');
        $this->db->from('tb_fornecedor_material f');
        $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
        $this->db->where('f.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listarconveniocirurgiaorcamento() {
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
        $this->db->orderby("c.nome");
        $query = $this->db->get();
        $return = $query->result();

        return $return;
    }

    function procedimentocirurgicovalor($agenda_exames_id) {

        $this->db->select('valor_total,
                            agenda_exames_id');
        $this->db->from('tb_agenda_exames');
        $this->db->where('agenda_exames_id', $agenda_exames_id);
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

        $this->db->select('DISTINCT(o.nome) as medico,aee.funcao as funcao_id,
                           gp.descricao as funcao,gp.codigo');
        $this->db->from('tb_agenda_exame_equipe aee');
        $this->db->join('tb_operador o', 'o.operador_id = aee.operador_responsavel', 'left');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = aee.funcao', 'left');
//        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = aee.agenda_exames_id', 'left');
        $this->db->where('aee.guia_id', $guia_id);
        $this->db->where('aee.ativo', 't');
        $this->db->where('gp.ativo', 't');
        $this->db->groupby('o.nome, gp.descricao,gp.codigo, aee.agenda_exame_equipe_id');
        $return2 = $this->db->get()->result();
//        var_dump($return2); die;
        return $return2;
    }

    function listarequipeoperadoreseditar($guia_id) {

        $this->db->select('DISTINCT(o.nome) as medico,aee.funcao as funcao_id,
                           gp.descricao as funcao,gp.codigo');
        $this->db->from('tb_agenda_exame_equipe aee');
        $this->db->join('tb_operador o', 'o.operador_id = aee.operador_responsavel', 'left');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = aee.funcao', 'left');
        $this->db->join('tb_equipe_cirurgia_operadores eco', 'eco.funcao = aee.funcao', 'left');
//        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = aee.agenda_exames_id', 'left');
        $this->db->where('aee.guia_id', $guia_id);
        $this->db->where('aee.ativo', 't');
        $this->db->where('gp.ativo', 't');
        $this->db->where('eco.ativo', 't');
        $this->db->groupby('o.nome, gp.descricao,gp.codigo, aee.agenda_exame_equipe_id');
        $return2 = $this->db->get()->result();
//        var_dump($return2); die;
        return $return2;
    }

    function carregarpercentualoutros($percentual_id) {
//        $data = date("Y-m-d");
        $this->db->select(" leito_enfermaria,
                            leito_apartamento,
                            via_diferente,
                            mesma_via,
                            valor_base,
                            valor");
        $this->db->from('tb_centrocirurgico_percentual_outros cpo');
        $this->db->where("cpo.ativo", 't');
        $this->db->where("cpo.centrocirurgico_percentual_outros_id", $percentual_id);
        $return = $this->db->get();
        return $return->result();
    }

    function carregarpercentualfuncao($percentual_id) {
//        $data = date("Y-m-d");
        $this->db->select(" cpf.valor,
                            cpf.valor_base,
                            gp.descricao,
                            gp.codigo");
        $this->db->from('tb_centrocirurgico_percentual_funcao cpf');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = cpf.funcao', 'left');
        $this->db->where("cpf.ativo", 't');
        $this->db->where("cpf.centrocirurgico_percentual_funcao_id", $percentual_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarpercentualoutros() {
//        $data = date("Y-m-d");
        $this->db->select(" centrocirurgico_percentual_outros_id,
                            leito_enfermaria,
                            leito_apartamento,
                            via_diferente,
                            mesma_via,
                            horario_especial,
                            valor_base,
                            valor");
        $this->db->from('tb_centrocirurgico_percentual_outros cpo');
        $this->db->where("cpo.ativo", 't');
        $this->db->orderby("cpo.leito_enfermaria");
        $this->db->orderby("cpo.via_diferente");
        $return = $this->db->get();
        return $return->result();
    }

    function atribuirpadraopercentualans() {
        $data = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $sql = "UPDATE ponto.tb_centrocirurgico_percentual_funcao
   SET valor=100.00, valor_base=100.00, data_percentual_padrao='$data', 
       operador_percentual_padrao=$operador_id
 WHERE funcao = 0;

UPDATE ponto.tb_centrocirurgico_percentual_funcao
   SET valor=30.00, valor_base=30.00, data_percentual_padrao='$data', 
       operador_percentual_padrao=$operador_id
 WHERE funcao = 1;

 UPDATE ponto.tb_centrocirurgico_percentual_funcao
   SET valor=100.00, valor_base=100.00, data_percentual_padrao='$data', 
       operador_percentual_padrao=$operador_id
 WHERE funcao = 6;

 UPDATE ponto.tb_centrocirurgico_percentual_funcao
   SET valor=20.00, valor_base=20.00, data_percentual_padrao='$data', 
       operador_percentual_padrao=$operador_id
 WHERE funcao NOT IN (1,6,0);
DELETE FROM ponto.tb_centrocirurgico_percentual_outros;
INSERT INTO ponto.tb_centrocirurgico_percentual_outros(leito_enfermaria, leito_apartamento, mesma_via, via_diferente, horario_especial, valor, valor_base) VALUES ('t', 'f', 't', 'f', 'f',100.00,50.00);
INSERT INTO ponto.tb_centrocirurgico_percentual_outros(leito_enfermaria, leito_apartamento, mesma_via, via_diferente, horario_especial, valor, valor_base) VALUES ('t', 'f', 'f', 't', 'f',100.00,70.00);
INSERT INTO ponto.tb_centrocirurgico_percentual_outros(leito_enfermaria, leito_apartamento, mesma_via, via_diferente, horario_especial, valor, valor_base) VALUES ('f', 't', 't', 'f', 'f',200.00,100.00); 
INSERT INTO ponto.tb_centrocirurgico_percentual_outros(leito_enfermaria, leito_apartamento, mesma_via, via_diferente, horario_especial, valor, valor_base) VALUES ('f', 't', 'f', 't', 'f',200.00,140.00); 
INSERT INTO ponto.tb_centrocirurgico_percentual_outros(leito_enfermaria, leito_apartamento, mesma_via, via_diferente, horario_especial, valor) VALUES ('f', 'f', 'f', 'f', 't',30.00); ";
        $this->db->query($sql);
        return true;
    }

    function listarpercentualfuncao() {
        $data = date("Y-m-d");
        $this->db->select(" cpf.centrocirurgico_percentual_funcao_id,
                            cpf.valor,
                            cpf.valor_base,
                            gp.descricao,
                            gp.codigo");
        $this->db->from('tb_centrocirurgico_percentual_funcao cpf');
        $this->db->join('tb_grau_participacao gp', 'gp.codigo = cpf.funcao', 'left');
        $this->db->where("cpf.ativo", 't');
        $this->db->where("gp.ativo", 't');
//        $this->db->where("gp.codigo !=", '0');
        $this->db->orderby("cpf.centrocirurgico_percentual_funcao_id");
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

    function instanciarfornecedormaterial($fornecedor_material_id) {

        $this->db->select('fornecedor_material_id, 
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
                               f.valor_taxa,
                               cep');
        $this->db->from('tb_fornecedor_material f');
        $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
        $this->db->where('f.fornecedor_material_id', $fornecedor_material_id);
        $return = $this->db->get();
        return $return->result();
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
                               f.valor_taxa,
                               cep');
        $this->db->from('tb_hospital f');
        $this->db->join('tb_municipio c', 'c.municipio_id = f.municipio_id', 'left');
        $this->db->where('f.hospital_id', $hospital_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitacoes2($args = array()) {

        $this->db->select(" p.paciente_id,
                            p.nome,
                            sc.solicitacao_cirurgia_id,
                            sc.data_prevista,
                            sc.orcamento,
                            sc.situacao_convenio,
                            sc.equipe_montada,
                            sc.encaminhado_paciente,
                            sc.liberada,
                            sc.orcamento_completo,
                            c.nome as convenio,
                            c.dinheiro,
                            c.convenio_id,
                            o.nome as medico,
                            o2.nome as medico_solicitante,
                            o3.nome as operador,
                            sc.situacao,
                            (
                                SELECT solicitacao_orcamento_convenio_id 
                                FROM ponto.tb_solicitacao_orcamento_convenio tb_soc
                                WHERE tb_soc.solicitacao_cirurgia_id = sc.solicitacao_cirurgia_id
                                AND ativo = 't'
                                LIMIT 1
                            ) as orcamento_convenio_id,
                            (
                                SELECT COUNT(*)
                                FROM ponto.tb_solicitacao_cirurgia_material tb_scm
                                WHERE tb_scm.solicitacao_cirurgia_id = sc.solicitacao_cirurgia_id
                                AND ativo = 't'
                            ) as qtde_material
                            ");
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_agendado', 'left');
        $this->db->join('tb_operador o2', 'o2.operador_id = sc.medico_solicitante', 'left');
        $this->db->join('tb_operador o3', 'o3.operador_id = sc.operador_cadastro', 'left');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->where('sc.autorizado', 'f');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
            }
        }

        return $this->db;
    }
    
    function relatoriocirurgiaconvenio() {
//        var_dump($_POST);die;
        $data = date("Y-m-d");
        $this->db->select(' 
                          sc.*,
                          p.nome as paciente,
                          o.nome as cirurgiao,
                          c.nome as convenio
                                                   
                          ');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id', 'left');
        $this->db->join('tb_convenio c', 'sc.convenio = c.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_cirurgiao', 'left');

        $this->db->where('sc.ativo = true');

        $data_inicio = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))) . ' 00:00:00';

        $this->db->where("sc.data_prevista >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("sc.data_prevista <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))) . ' 23:59:59');
        
        if ($_POST['convenio'] != '') {
            if ($_POST['convenio'] == '-1') {
                $this->db->where('c.convenio_id', null);
            } else {
                $this->db->where('c.convenio_id', $_POST['convenio']);
            }
        }
        $this->db->orderby("sc.data_prevista");
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
        $this->db->where('gf.grupo_id', $financeiro_grupo_id);
        if ($credito == 'f') {
            $this->db->where('fp.forma_pagamento_id !=', 1000);
        }
        $this->db->orderby('fp.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguiaformaprocedimentos($guia_id, $financeiro_grupo_id) {
        $this->db->select('sum((valor * quantidade)) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio_pagamento cp', 'cp.procedimento_convenio_id = ae.procedimento_tuss_id');
        $this->db->where("guia_id", $guia_id);
        $this->db->where("ae.faturado", 'f');
        if ($financeiro_grupo_id != null) {
            $this->db->where("cp.grupo_pagamento_id", $financeiro_grupo_id);
        }
        $return = $this->db->get();
//        var_dump($guia_id); die;
        return $return->result();
    }

    function listarexameguiaformaequipe($guia_id) {
        $this->db->select('sum(aee.valor) as total');
        $this->db->from('tb_agenda_exame_equipe aee');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = aee.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where("aee.guia_id", $guia_id);
        $this->db->where("aee.faturado", 'f');
        $this->db->where("aee.ativo", 't');
        $this->db->where("(c.dinheiro ='t' = aee.equipe_particular = 't')");
//        $this->db->where("ae.faturado", 'f');

        $return = $this->db->get();
//        var_dump($guia_id); die;
        return $return->result();
    }

    function listarsalascirurgico() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('an.exame_sala_id,
                            an.nome, an.tipo');
        $this->db->from('tb_exame_sala an');
        $this->db->join('tb_exame_sala_grupo esg', 'esg.exame_sala_id = an.exame_sala_id', 'left');
        $this->db->where('an.empresa_id', $empresa_id);
        $this->db->where('an.excluido', 'f');
        $this->db->where('esg.grupo', 'CIRURGICO');
        $this->db->where('esg.ativo', 't');
        $this->db->orderby('an.nome');
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

    function listarexameguiaprocedimentos($guia_id) {

        $this->db->select('sum((valor * quantidade)) as total');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'pt.grupo = ag.nome', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('faturado', 'f');
        $this->db->where('ag.tipo', 'CIRURGICO');
        $this->db->where('c.dinheiro', 't');
        $this->db->where("guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarexameguiaequipe($guia_id) {

        $this->db->select('sum(aee.valor) as total');
        $this->db->from('tb_agenda_exame_equipe aee');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = aee.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('aee.faturado', 'f');
        $this->db->where("aee.ativo", 't');
        $this->db->where("(c.dinheiro = 't' OR aee.equipe_particular = 't')");
        $this->db->where("aee.guia_id", $guia_id);
        $return = $this->db->get();
        return $return->result();
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
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
            $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_ambulatorio_grupo ag', 'pt.grupo = ag.nome', 'left');
            if ($_POST['financeiro_grupo_id'] != '') {
                $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
                $this->db->join('tb_financeiro_grupo fg', 'fg.financeiro_grupo_id = pp.grupo_pagamento_id', 'left');
                $this->db->where("financeiro_grupo_id", $_POST['financeiro_grupo_id']);
            }
            $this->db->where("guia_id", $guia);
            $this->db->where('faturado', 'f');
            $this->db->where('ag.tipo', 'CIRURGICO');
            $this->db->where('c.dinheiro', 'true');
            $query = $this->db->get();
            $returno = $query->result();
//            echo '<pre>';
//            var_dump($returno);
//            die;

            $this->db->set('situacao', 'AGUARDANDO');
            $this->db->where('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
            $this->db->update('tb_solicitacao_cirurgia');

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

    function gravarfaturamentototalequipe() {
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

            $this->db->select('aee.agenda_exame_equipe_id, aee.valor as valor_total, aee.guia_id, ae.paciente_id');
            $this->db->from('tb_agenda_exame_equipe aee');
            $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = aee.agenda_exames_id', 'left');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
            $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_ambulatorio_grupo ag', 'pt.grupo = ag.nome', 'left');
            if ($_POST['financeiro_grupo_id'] != '') {
                $this->db->join('tb_procedimento_convenio_pagamento pp', 'pp.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
                $this->db->join('tb_financeiro_grupo fg', 'fg.financeiro_grupo_id = pp.grupo_pagamento_id', 'left');
                $this->db->where("financeiro_grupo_id", $_POST['financeiro_grupo_id']);
            }
            $this->db->where("aee.guia_id", $guia);
            $this->db->where('aee.faturado', 'f');
            $this->db->where('ag.tipo', 'CIRURGICO');
            $this->db->where("(c.dinheiro = 't' OR aee.equipe_particular = 't')");
            $query = $this->db->get();
            $returno = $query->result();
//            echo '<pre>';
//            var_dump($returno);
//            die;

            $this->db->set('situacao', 'EQUIPE_FATURADA');
            $this->db->where('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
            $this->db->update('tb_solicitacao_cirurgia');

            $this->db->set('operador_id', $operador_id);
            $this->db->set('agenda_exame_equipe_id', $returno[0]->agenda_exame_equipe_id);
            $this->db->set('valor_total', $desconto);
            $this->db->set('guia_id', $returno[0]->guia_id);
            $this->db->set('paciente_id', $returno[0]->paciente_id);
            $this->db->insert('tb_ambulatorio_desconto');

            $forma1 = $_POST['formapamento1'];
            $forma2 = $_POST['formapamento2'];
            $forma3 = $_POST['formapamento3'];
            $forma4 = $_POST['formapamento4'];

            $id_juros = $returno[0]->agenda_exame_equipe_id;
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
                    $this->db->set('forma_pagamento1', $_POST['formapamento1']);
                    $this->db->set('valor1', str_replace(",", ".", $valortotal));
                    $this->db->set('desconto_ajuste1', $desconto_cartao1);
                    $this->db->set('parcelas1', $_POST['parcela1']);
                    $this->db->set('valor', str_replace(",", ".", $valortotal));
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exame_equipe_id', $value->agenda_exame_equipe_id);
                    $this->db->update('tb_agenda_exame_equipe');
                    $i = 1;
                } elseif ($i != 1 && $valor2 > 0 && $valor1 < $valortotal && $valor2 >= ($valortotal - $valor1)) {
//                    echo 'if2';
                    $valor2 = $valor2 - ($valortotal - $valor1);
                    $restovalor2 = $valortotal - $valor1;
                    if ($valor1 > 0) {
                        $this->db->set('forma_pagamento1', $_POST['formapamento1']);
                        $this->db->set('valor1', str_replace(",", ".", $valor1));
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
                        $this->db->set('parcelas1', $_POST['parcela1']);
                        $this->db->set('forma_pagamento2', $_POST['formapamento2']);
                        $this->db->set('valor2', str_replace(",", ".", $restovalor2));
                        $this->db->set('parcelas2', $_POST['parcela2']);
                    }
                    if ($valor1 == 0) {
                        $this->db->set('forma_pagamento1', $_POST['formapamento2']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor2));
                        $this->db->set('parcelas1', $_POST['parcela2']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('faturado', 't');
                    $this->db->set('valor', str_replace(",", ".", $valortotal));
                    $this->db->where('agenda_exame_equipe_id', $value->agenda_exame_equipe_id);
                    $this->db->update('tb_agenda_exame_equipe');
                    $valor1 = 0;
                    $i = 2;
                } elseif ($i != 1 && $i != 2 && $valor3 > 0 && $valor2 < $valortotal && $valor3 >= ($valortotal - ($valor1 + $valor2))) {
//                    echo 'if3';
                    $valor3 = $valor3 - ($valortotal - ($valor2 + $valor1));
                    $restovalor3 = $valortotal - ($valor2 + $valor1);
                    if ($valor1 > 0 && $valor2 > 0) {
                        $this->db->set('forma_pagamento1', $_POST['formapamento1']);
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
                        $this->db->set('forma_pagamento1', $_POST['formapamento2']);
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
                        $this->db->set('forma_pagamento1', $_POST['formapamento1']);
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
                        $this->db->set('forma_pagamento1', $_POST['formapamento3']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor3));
                        $this->db->set('parcelas1', $_POST['parcela3']);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exame_equipe_id', $value->agenda_exame_equipe_id);
                    $this->db->update('tb_agenda_exame_equipe');
                    $valor2 = 0;
                    $valor1 = 0;
                    $i = 3;
                } elseif ($i != 1 && $i != 2 && $i != 3 && $valor2 < ($valortotal - $valor1) && $valor3 < ($valortotal - ($valor1 + $valor2)) && $valor4 >= ($valortotal - ($valor1 + $valor2 + $valor3))) {
//                    echo 'if4';
                    $valor4 = $valor4 - ($valortotal - ($valor3 + $valor2 + $valor1));
                    $restovalor4 = $valortotal - ($valor3 + $valor2 + $valor1);
                    if ($valor1 > 0 && $valor2 > 0 && $valor3 > 0) {
                        $this->db->set('forma_pagamento1', $_POST['formapamento1']);
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
                        $this->db->set('forma_pagamento1', $_POST['formapamento2']);
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
                        $this->db->set('forma_pagamento1', $_POST['formapamento1']);
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
                        $this->db->set('forma_pagamento1', $_POST['formapamento1']);
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
                        $this->db->set('forma_pagamento1', $_POST['formapamento3']);
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
                        $this->db->set('forma_pagamento1', $_POST['formapamento1']);
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
                        $this->db->set('forma_pagamento1', $_POST['formapamento2']);
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
                        $this->db->set('forma_pagamento1', $_POST['formapamento4']);
                        $this->db->set('valor1', str_replace(",", ".", $restovalor4));
                        $this->db->set('parcelas1', $_POST['parcela4']);
                        $this->db->set('desconto_ajuste1', $desconto_cartao1);
//                        $this->db->set('desconto_ajuste2', $desconto_cartao2);
//                        $this->db->set('desconto_ajuste3', $desconto_cartao3);
//                        $this->db->set('desconto_ajuste4', $desconto_cartao4);
                    }
                    $this->db->set('data_faturamento', $horario);
                    $this->db->set('operador_faturamento', $operador_id);
                    $this->db->set('valor', str_replace(",", ".", $valortotal));
                    $this->db->set('faturado', 't');
                    $this->db->where('agenda_exame_equipe_id', $value->agenda_exame_equipe_id);
                    $this->db->update('tb_agenda_exame_equipe');
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
                    $this->db->set('valor', $valortotal_juros);
                    $this->db->set('valor4', $juros);
                    $this->db->where('agenda_exame_equipe_id', $value->agenda_exame_equipe_id);
                    $this->db->update('tb_agenda_exame_equipe');
                }
                /* inicia o mapeamento no banco */
            }
//            die;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarcirurgia($args = array()) {

        $this->db->select(' p.paciente_id,
                            p.nome,
                            sc.solicitacao_cirurgia_id,
                            sc.guia_id,
                            sc.situacao,
                            sc.data_cadastro,
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
//                $this->db->where("sc.data_prevista <=", "$pesquisa2");
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

    function listarcirurgiacalendario($medico = null) {

        $this->db->select('
                            sc.solicitacao_cirurgia_id,
                            p.nome,
                            p.celular,
                            p.telefone,
                            p.nascimento,
                            fm.nome as fornecedor,
                            o2.nome as cirurgiao,
                            o2.cor_mapa,
                            c.nome as convenio,
                            sc.autorizado,
                            sc.observacao,
                            h.nome as hospital,
                            sc.hora_prevista,
                            sc.hora_prevista_fim,
                            sc.data_prevista');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_equipe_cirurgia_operadores eco', 'eco.solicitacao_cirurgia_id = sc.solicitacao_cirurgia_id', 'left');
        $this->db->join('tb_internacao i', 'i.internacao_id = sc.internacao_id', 'left');
        $this->db->join('tb_hospital h', 'h.hospital_id = sc.hospital_id', 'left');
        $this->db->join('tb_fornecedor_material fm', 'fm.fornecedor_material_id = sc.fornecedor_id', 'left');
        $this->db->join('tb_convenio c', 'sc.convenio = c.convenio_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_solicitante', 'left');
        $this->db->join('tb_operador o2', 'o2.operador_id = eco.operador_responsavel', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id ', 'left');
        $this->db->where('eco.funcao', '0');
        $this->db->where('eco.ativo', 't');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
//        $this->db->where('sc.autorizado', 't');
        if ($medico != null) {
            $this->db->where('eco.operador_responsavel', $medico);
        }
        $this->db->groupby('
                            sc.solicitacao_cirurgia_id,
                            p.nome,
                            p.celular,
                            p.telefone,
                            p.nascimento,
                            fm.nome,
                            o2.nome,
                            c.nome,
                            sc.autorizado,
                            o2.cor_mapa,
                            h.nome,
                            sc.hora_prevista,
                            sc.hora_prevista_fim,
                            sc.data_prevista');



        $return = $this->db->get();
        return $return->result();
    }

    function listacalendarioanestesistaautocomplete($solicitacao_id) {
        $this->db->select('o.nome');
        $this->db->from('tb_equipe_cirurgia_operadores eco');
        $this->db->join('tb_operador o', 'o.operador_id = eco.operador_responsavel', 'left');
        $this->db->where('eco.ativo', 'true');
        $this->db->where('eco.funcao', 6);
        $this->db->where('eco.solicitacao_cirurgia_id', $solicitacao_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listacalendarioprocedimentoautocomplete($solicitacao_id) {
        $this->db->select('scp.solicitacao_cirurgia_procedimento_id as solicitacao_procedimento_id,
                           c.nome as convenio,
                           pt.nome');
        $this->db->from('tb_solicitacao_cirurgia_procedimento scp');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = scp.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('scp.ativo', 'true');
        $this->db->where('scp.solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->orderby('scp.valor desc');
        $this->db->limit(1);
        $return = $this->db->get();
        return $return->result();
    }

    function relatoriocaixacirurgico() {

        $this->db->select('ae.agenda_exames_id,
                            ae.agenda_exames_nome_id,
                            ae.data,
                            ae.guia_id,
                            ae.inicio,
                            ae.fim,
                            ae.financeiro,
                            ae.faturado,
                            ae.ativo,
                            ae.data_faturar,
                            ae.verificado,
                            ae.situacao,
                            pt.grupo,
                            c.nome as convenio,
                            c.dinheiro,
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
                            o2.nome as cirurgiao,
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
        $this->db->join('tb_ambulatorio_grupo ag', 'pt.grupo = ag.nome', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_agenda_exame_equipe aee', 'aee.agenda_exames_id = ae.agenda_exames_id', 'left');
//        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_forma_pagamento f', 'f.forma_pagamento_id = ae.forma_pagamento', 'left');
        $this->db->join('tb_forma_pagamento f2', 'f2.forma_pagamento_id = ae.forma_pagamento2', 'left');
        $this->db->join('tb_forma_pagamento f3', 'f3.forma_pagamento_id = ae.forma_pagamento3', 'left');
        $this->db->join('tb_forma_pagamento f4', 'f4.forma_pagamento_id = ae.forma_pagamento4', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.operador_autorizacao', 'left');
        $this->db->join('tb_operador o2', 'o2.operador_id = aee.operador_responsavel', 'left');
        $this->db->join('tb_operador_grupo_medico ogm', 'ae.medico_consulta_id = ogm.operador_id', 'left');
//        $this->db->join('tb_operador_grupo og', 'og.operador_grupo_id = ogm.operador_grupo_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_faturamento', 'left');
//        $this->db->where('ae.cancelada', 'false');
        $this->db->where('aee.funcao', 0);
        $this->db->where("(c.dinheiro = 't' OR ae.equipe_particular = 't')");
        $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->where('ag.tipo', 'CIRURGICO');
//        if ($_POST['grupo'] != "0" && $_POST['grupo'] != "1") {
//            $this->db->where('pt.grupo', $_POST['grupo']);
//        }
//        if ($_POST['procedimentos'] != "0") {
//            $this->db->where('pt.procedimento_tuss_id', $_POST['procedimentos']);
//        }
        if ($_POST['medico'] != "0") {
            $this->db->where('aee.operador_responsavel', $_POST['medico']);
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

    function fecharcaixacirurgico() {
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
        $observacao = "Periodo de " . date("d/m/Y", strtotime(str_replace("/", "-", $_POST['data1']))) . " a " . date("d/m/Y", strtotime(str_replace("/", "-", $_POST['data2'])));
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

        $teste = $_POST['qtde'];
        foreach ($forma_pagamento as $value) {

            $classe = "CAIXA CIRURGICO" . " " . $value->nome;

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
//                            $valor_n_parcelado = $valor_total;
//                            $agenda_exames_id = $this->relatoriocaixaformacredito($value->forma_pagamento_id);
//                            foreach ($agenda_exames_id as $item) {
//                                if ($item->forma_pagamento == $value->forma_pagamento_id) {
//                                    $parcelas = $item->parcelas1;
//                                    $valor = $item->valor1;
////                                    $retorno = $this->parcelas1($item->agenda_exames_id);
//                                } elseif ($item->forma_pagamento2 == $value->forma_pagamento_id) {
//                                    $parcelas = $item->parcelas2;
//                                    $valor = $item->valor2;
////                                    $retorno = $this->parcelas2($item->agenda_exames_id);
//                                } elseif ($item->forma_pagamento3 == $value->forma_pagamento_id) {
//                                    $parcelas = $item->parcelas3;
//                                    $valor = $item->valor3;
////                                    $retorno = $this->parcelas3($item->agenda_exames_id);
//                                } elseif ($item->forma_pagamento4 == $value->forma_pagamento_id) {
//                                    $parcelas = $item->parcelas4;
//                                    $valor = $item->valor4;
////                                    $retorno = $this->parcelas4($item->agenda_exames_id);
//                                }
//
//                                if ($parcelas != '') {
//                                    $jurosporparcelas = $this->jurosporparcelas($value->forma_pagamento_id, $parcelas);
////                                    var_dump($jurosporparcelas); die;
//                                    if (@$jurosporparcelas[0]->taxa_juros > 0) {
//                                        $taxa_juros = $jurosporparcelas[0]->taxa_juros;
//                                    } else {
//                                        $taxa_juros = 0;
//                                    }
//                                    $taxa_parcela = $valor * ($taxa_juros / 100);
//                                    $valor_com_juros = $valor - $taxa_parcela;
//                                    $valor_parcelado = $valor_com_juros / $parcelas;
//                                } else {
//                                    $valor_parcelado = $valor;
//                                }
//
//                                $tempo_receber = $value->tempo_receber;
////                                if ($parcelas > 1) {
//                                for ($i = 1; $i <= $parcelas; $i++) {
//
//                                    $tempo_receber = $tempo_receber + $value->tempo_receber;
//                                    $data_atual = $_POST['data1'];
//
//                                    if ($i == 1) {
//                                        $data_receber_p = date("Y-m-d", strtotime("+$value->tempo_receber days", strtotime($data_atual)));
//                                    }
//
//                                    $this->db->set('valor', $valor_parcelado);
//                                    $this->db->set('devedor', $value->credor_devedor);
//                                    $this->db->set('parcela', $i);
//                                    $this->db->set('data', $data_receber_p);
//                                    $this->db->set('classe', $classe);
//                                    $this->db->set('conta', $value->conta_id);
//                                    $this->db->set('observacao', $observacao);
//                                    $this->db->set('data_cadastro', $horario);
//                                    $this->db->set('operador_cadastro', $operador_id);
//                                    $this->db->insert('tb_financeiro_contasreceber_temp');
//
//                                    $data_receber_p = date("Y-m-d", strtotime("+$tempo_receber days", strtotime($data_atual)));
//                                }
//                                $valor_n_parcelado = $valor_n_parcelado - $valor + $valor_parcelado;
//                            }
//
//                            $receber_temp = $this->burcarcontasrecebertemp();
//
//                            foreach ($receber_temp as $temp) {
//                                $receber_temp2 = $this->burcarcontasrecebertemp2($temp->data);
//                                $this->db->set('valor', $receber_temp2[0]->valor);
//                                $this->db->set('devedor', $receber_temp2[0]->devedor);
//                                $this->db->set('data', $temp->data);
//                                $this->db->set('parcela', $receber_temp2[0]->parcela);
//                                $this->db->set('numero_parcela', $parcelas);
//                                $this->db->set('classe', $receber_temp2[0]->classe);
//                                $this->db->set('conta', $receber_temp2[0]->conta);
//                                $this->db->set('observacao', $receber_temp2[0]->observacao);
//                                $this->db->set('data_cadastro', $receber_temp2[0]->data_cadastro);
//                                $this->db->set('empresa_id', $empresa_id);
////                                                            var_dump($empresa_id); die;
//                                $this->db->set('operador_cadastro', $receber_temp2[0]->operador_cadastro);
//                                $this->db->insert('tb_financeiro_contasreceber');
//                            }
                            $this->db->set('ativo', 'f');
                            $this->db->update('tb_financeiro_contasreceber_temp');
                        }
                    }
                }
            }
        }



        $empresa = (isset($_POST['empresa']) ? ' AND ae.empresa_id = ' . $_POST['empresa'] : '');

//        if ($_POST['grupo'] == 0) {
//echo 'ausdahusdas'; die;
        $sql = "UPDATE ponto.tb_agenda_exames
SET operador_financeiro = $operador_id, data_financeiro= '$horario', financeiro = 't'
where agenda_exames_id in (SELECT ae.agenda_exames_id
FROM ponto.tb_agenda_exames ae 
LEFT JOIN ponto.tb_procedimento_convenio pc ON pc.procedimento_convenio_id = ae.procedimento_tuss_id 
LEFT JOIN ponto.tb_procedimento_tuss pt ON pt.procedimento_tuss_id = pc.procedimento_tuss_id 
LEFT JOIN ponto.tb_ambulatorio_grupo ag ON pt.grupo = ag.nome 
LEFT JOIN ponto.tb_exames e ON e.agenda_exames_id = ae.agenda_exames_id 
LEFT JOIN ponto.tb_ambulatorio_laudo al ON al.exame_id = e.exames_id 
LEFT JOIN ponto.tb_convenio c ON c.convenio_id = pc.convenio_id 
WHERE ae.data >= '$data_inicio' 
AND ae.data <= '$data_fim' 
AND ag.tipo = 'CIRURGICO' 
$empresa
AND c.dinheiro = true 
ORDER BY ae.agenda_exames_id)";
        $this->db->query($sql);
//        }
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

    function jurosporparcelas($formapagamento_id, $parcelas) {
        $this->db->select('taxa_juros');
        $this->db->from('tb_formapagamento_pacela_juros');
        $this->db->where('forma_pagamento_id', $formapagamento_id);
        $this->db->where('parcelas_inicio <=', $parcelas);
        $this->db->where('parcelas_fim >=', $parcelas);
        $query = $this->db->get();

        return $query->result();
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

    function relatoriocaixacirurgicocontador() {
        $this->db->select('ae.agenda_exames_id');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo ag', 'pt.grupo = ag.nome', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.operador_autorizacao >', 0);
        $this->db->where("ae.data_faturar >=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_inicio']))));
        $this->db->where("ae.data_faturar <=", date("Y-m-d", strtotime(str_replace('/', '-', $_POST['txtdata_fim']))));
        $this->db->where('ag.tipo', 'CIRURGICO');

//        if ($_POST['medico'] != "0") {
//            $this->db->where('al.medico_parecer1', $_POST['medico']);
//        }
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

//    function listarequipeoperadoresfuncao() {
//        try {
//            /* inicia o mapeamento no banco */
//            $_POST['valor'] = (float) str_replace(',', '.', str_replace('.', '', $_POST['valor']));
//
//            $this->db->set('funcao', $_POST['funcao']);
//            $this->db->set('operador_responsavel', $_POST['medico']);
//            $this->db->set('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
//
//            $horario = date("Y-m-d H:i:s");
//            $operador_id = $this->session->userdata('operador_id');
//
//            $this->db->set('data_cadastro', $horario);
//            $this->db->set('operador_cadastro', $operador_id);
//            $this->db->insert('tb_equipe_cirurgia_operadores');
//        } catch (Exception $exc) {
//            return -1;
//        }
//    }

    function listarequipeoperadoresfuncao() {
        $this->db->select('funcao');
        $this->db->from('tb_equipe_cirurgia_operadores');
        $this->db->where("(funcao = '{$_POST['funcao']}' OR operador_responsavel = {$_POST['medico']})");
        $this->db->where('ativo', 't');
        $this->db->where('solicitacao_cirurgia_id', $_POST['solicitacao_id']);
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentoconveniocirurgicoagrupador($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento, 
                            pt.codigo');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pt.grupo", 'CIRURGICO');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentoscirurgico($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where("pt.grupo", 'CIRURGICO');
        $this->db->where('pc.convenio_id', $parametro);
        $this->db->orderby("pt.nome");
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

    function gravarpercentualhorarioespecial() {
        try {
            /* inicia o mapeamento no banco */
            $_POST['valor'] = (float) str_replace(',', '.', str_replace('.', '', $_POST['valor']));

            $this->db->set('valor', $_POST['valor']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('centrocirurgico_percentual_outros_id', $_POST['percentual_id']);
            $this->db->update('tb_centrocirurgico_percentual_outros');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpercentualoutros() {
        try {
            /* inicia o mapeamento no banco */
            $_POST['maior_valor'] = (float) str_replace(',', '.', str_replace('.', '', $_POST['maior_valor']));
            $_POST['valor_base'] = (float) str_replace(',', '.', str_replace('.', '', $_POST['valor_base']));

            $this->db->set('valor', $_POST['maior_valor']);
            $this->db->set('valor_base', $_POST['valor_base']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('centrocirurgico_percentual_outros_id', $_POST['percentual_id']);
            $this->db->update('tb_centrocirurgico_percentual_outros');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarpercentualfuncao() {
        try {
            /* inicia o mapeamento no banco */
//            $_POST['maior_valor'] = (float) str_replace(',', '.', str_replace('.', '', $_POST['maior_valor']));
//            $_POST['valor_base'] = (float) str_replace(',', '.', str_replace('.', '', $_POST['valor_base']));
//            $this->db->set('valor', $_POST['maior_valor']);
//            $this->db->set('valor_base', $_POST['valor_base']);

            $_POST['valor'] = (float) str_replace(',', '.', str_replace('.', '', $_POST['valor']));
            $this->db->set('valor', $_POST['valor']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('centrocirurgico_percentual_funcao_id', $_POST['percentual_id']);
            $this->db->update('tb_centrocirurgico_percentual_funcao');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function finalizarequipecirurgica($solicitacaocirurgia_id) {
        try {
            $this->db->select('orcamento');
            $this->db->from('tb_solicitacao_cirurgia');
            $this->db->where('solicitacao_cirurgia_id', $solicitacaocirurgia_id);
            $return = $this->db->get()->result();
//            $return;
            if ($return[0]->orcamento == 't') {
                $this->db->set('situacao', 'ORCAMENTO_INCOMPLETO');
                $this->db->set('situacao_convenio', 'ORCAMENTO_INCOMPLETO');
            } else {
                $this->db->set('situacao', 'EQUIPE_MONTADA');
                $this->db->set('situacao_convenio', 'EQUIPE_MONTADA');
            }


            $this->db->set('equipe_montada', 't');
            $this->db->where('solicitacao_cirurgia_id', $solicitacaocirurgia_id);
            $this->db->update('tb_solicitacao_cirurgia');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarequipeoperadores($cirurgiao_id) {
        try {
//            var_dump($cirurgiao_id);die;
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

    function gravarfornecedormaterial() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);

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
                $this->db->insert('tb_fornecedor_material');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $fornecedor_material_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $fornecedor_material_id = $_POST['txtempresaid'];
                $this->db->where('fornecedor_material_id', $fornecedor_material_id);
                $this->db->update('tb_fornecedor_material');
            }
            return $fornecedor_material_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarhospital() {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', $_POST['txtNome']);

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

            $this->db->set('valor_taxa', str_replace(",", ".", str_replace(".", "", $_POST['valor_taxa'])));


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

    function excluirguiacirurgica($guia) {
        try {
            $this->db->where('guia_id', $guia);
            $this->db->delete('tb_agenda_exames');

            $this->db->where('ambulatorio_guia_id', $guia);
            $this->db->delete('tb_ambulatorio_guia');
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

    function confirmarcirurgia($solicitacao_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('situacao', 'REALIZADA');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
            $this->db->update('tb_solicitacao_cirurgia');
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

    function excluirfornecedormaterial($hospital_id) {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('fornecedor_material_id', $hospital_id);
            $this->db->update('tb_fornecedor_material');
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
        $this->db->select('grau_participacao_id');
        $this->db->from('tb_grau_participacao');
        $this->db->where('codigo', $_POST['txtcodigo']);
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        if (count($return->result()) > 0) {
            return -1;
        }

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('codigo', $_POST['txtcodigo']);
        $this->db->set('descricao', $_POST['txtNome']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_grau_participacao');
    }

    function liberarsolicitacao($solicitacao_id, $orcamento) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('liberada', 't');
        $this->db->set('data_liberacao', $horario);
        $this->db->set('operador_liberacao', $operador_id);

        $this->db->set('situacao', 'EQUIPE_NAO_MONTADA');
        $this->db->set('situacao_convenio', 'EQUIPE_NAO_MONTADA');

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
        $this->db->set('situacao_convenio', 'ORCAMENTO_INCOMPLETO');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->update('tb_solicitacao_cirurgia');

        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return true;
        }
    }

    function alterardatacirurgiajson($solicitacao_id) {
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');

        $_POST['dataprevista'] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_POST['dataprevista'])));

        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->set('data_prevista', date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $_GET['txtdata']))));
        $this->db->set('hora_prevista', date("H:i:s", strtotime(str_replace('/', '-', $_GET['hora']))));
        $this->db->set('hora_prevista_fim', date("H:i:s", strtotime(str_replace('/', '-', $_GET['hora_fim']))));
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
        $this->db->set('situacao_convenio', 'ORCAMENTO_COMPLETO');
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
        $this->db->set('situacao_convenio', 'ORCAMENTO_COMPLETO');
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
        $this->db->set('situacao_convenio', 'EQUIPE_MONTADA');
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
    
    function listarcirurgiao($solicitacaocirurgia_id) {
        $this->db->select('s.medico_cirurgiao, o.nome');
        $this->db->from('tb_solicitacao_cirurgia s');
        $this->db->join('tb_operador o', 'o.operador_id = s.medico_cirurgiao');        
        $this->db->where('solicitacao_cirurgia_id', $solicitacaocirurgia_id);
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

