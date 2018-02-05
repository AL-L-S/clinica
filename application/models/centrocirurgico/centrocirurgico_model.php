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
                            c.nome as convenio,
                            c.convenio_id,
                            o.nome as medico,
                            sc.situacao');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->where('sc.ativo', 't');
        $this->db->where('sc.excluido', 'f');
        $this->db->where('sc.autorizado', 'f');
        $this->db->where('solicitacao_cirurgia_id', $solicitacao_id);
        $this->db->join('tb_paciente p', 'p.paciente_id = sc.paciente_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = sc.convenio', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = sc.medico_agendado', 'left');

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

    function listarlaudosolicitacaocirurgica($laudo_id) {
        $this->db->select('medico_parecer1, 
                           p.nome,
                           p.paciente_id');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->join('tb_paciente p', 'p.paciente_id = al.paciente_id', 'left');
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

    function listarconveniocirurgiaorcamento() {
        $this->db->select('convenio_id,
                            nome,');
        $this->db->from('tb_convenio');
        $this->db->where("ativo", 't');
        $this->db->orderby('nome');
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

        $this->db->select(' p.paciente_id,
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

    function listarcirurgia($args = array()) {

        $this->db->select(' p.paciente_id,
                            p.nome,
                            sc.solicitacao_cirurgia_id,
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

    function listarcirurgiacalendario($medico = null) {

        $this->db->select('
                            sc.solicitacao_cirurgia_id,
                            p.nome,
                            p.celular,
                            p.telefone,
                            p.nascimento,
                            o2.nome as cirurgiao,
                            o2.cor_mapa,
                            c.nome as convenio,
                            h.nome as hospital,
                            sc.hora_prevista,
                            sc.hora_prevista_fim,
                            sc.data_prevista');
        $this->db->from('tb_solicitacao_cirurgia sc');
        $this->db->join('tb_equipe_cirurgia_operadores eco', 'eco.solicitacao_cirurgia_id = sc.solicitacao_cirurgia_id', 'left');
        $this->db->join('tb_internacao i', 'i.internacao_id = sc.internacao_id', 'left');
        $this->db->join('tb_hospital h', 'h.hospital_id = sc.hospital_id', 'left');
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
                            o2.nome,
                            c.nome,
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

