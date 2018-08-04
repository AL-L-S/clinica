<?php

class laudo_model extends Model {

    var $_ambulatorio_laudo_id = null;
    var $_texto = null;
    var $_situacaolaudo = null;
    var $_agenda_exames_id = null;
    var $_medico_parecer1 = null;
    var $_medico_parecer2 = null;
    var $_revisor = null;
    var $_status = null;
    var $_agrupador_fisioterapia = null;
    var $_assinatura = null;
    var $_rodape = null;
    var $_cabecalho = null;
    var $_grupo = null;
    var $_sala = null;
    var $_sala_id = null;
    var $_guia_id = null;
    var $_nome = null;
    var $_Idade = null;
    var $_indicado = null;
    var $_indicacao = null;
    var $_procedimento = null;
    var $_nascimento = null;
    var $_telefone = null;
    var $_uf = null;
    var $_bairro = null;
    var $_logradouro = null;
    var $_numero = null;
    var $_solicitante = null;
    var $_quantidade = null;
    var $_convenio = null;
    var $_sexo = null;
    var $_imagens = null;
    var $_cid = null;
    var $_ciddescricao = null;
    var $_cid2 = null;
    var $_cid2descricao = null;
    var $_peso = null;
    var $_altura = null;
    var $_pasistolica = null;
    var $_padiastolica = null;
    var $_superficie_corporea = null;
    var $_ve_volume_telediastolico = null;
    var $_ve_volume_telessistolico = null;
    var $_ve_diametro_telediastolico = null;
    var $_ve_diametro_telessistolico = null;
    var $_ve_indice_do_diametro_diastolico = null;
    var $_ve_septo_interventricular = null;
    var $_ve_parede_posterior = null;
    var $_ve_relacao_septo_parede_posterior = null;
    var $_ve_espessura_relativa_paredes = null;
    var $_ve_massa_ventricular = null;
    var $_ve_indice_massa = null;
    var $_ve_relacao_volume_massa = null;
    var $_ve_fracao_ejecao = null;
    var $_ve_fracao_encurtamento = null;
    var $_vd_diametro_telediastolico = null;
    var $_vd_area_telediastolica = null;
    var $_ae_diametro = null;
    var $_ae_volume = null;
    var $_ad_volume = null;
    var $_ad_volume_indexado = null;
    var $_vd_diametro_pel = null;
    var $_vd_diametro_basal = null;
    var $_ao_diametro_raiz = null;
    var $_paciente_id = null;
    var $_ao_relacao_atrio_esquerdo_aorta = null;

    function laudo_model($ambulatorio_laudo_id = null) {
        parent::Model();
        if (isset($ambulatorio_laudo_id)) {
            $this->instanciar($ambulatorio_laudo_id);
        }
    }

    function validar() {
        $senha = $_POST['senha'];
        $medico = $_POST['medico'];


        $this->db->select(' o.operador_id,
                                o.perfil_id,
                                p.nome as perfil,
                                a.modulo_id'
        );
        $this->db->from('tb_operador o');
        $this->db->join('tb_perfil p', 'p.perfil_id = o.perfil_id');
        $this->db->join('tb_acesso a', 'a.perfil_id = o.perfil_id', 'left');
        $this->db->where('o.operador_id', $medico);
        $perfil_id = $this->session->userdata('perfil_id');
        if ($perfil_id != 1) {
            $this->db->where('o.senha', md5($senha));
        }
        $this->db->where('o.ativo = true');
        $this->db->where('p.ativo = true');
        $return = $this->db->get()->result();

        if (isset($return) && count($return) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function validarrevisor() {
        $senha = $_POST['senha'];
        $medico = $_POST['medicorevisor'];


        $this->db->select(' o.operador_id,
                                o.perfil_id,
                                p.nome as perfil,
                                a.modulo_id'
        );
        $this->db->from('tb_operador o');
        $this->db->join('tb_perfil p', 'p.perfil_id = o.perfil_id');
        $this->db->join('tb_acesso a', 'a.perfil_id = o.perfil_id', 'left');
        $perfil_id = $this->session->userdata('perfil_id');
        if ($perfil_id != 1) {
//        $this->db->where('o.senha', md5($senha));
//        $this->db->where('o.operador_id', $medico);
        }
        $this->db->where('o.ativo = true');
        $this->db->where('p.ativo = true');
        $return = $this->db->get()->result();
//        var_dump($return); die;
        if (isset($return) && count($return) > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function listarlaudosintegracaotodos() {
        $this->db->select('il.exame_id');
        $this->db->from('tb_integracao_laudo il');
        $this->db->join('tb_operador o', 'o.conselho = il.laudo_conselho_medico', 'left');
        $this->db->join('tb_operador op', 'op.conselho = il.laudo_conselho_medico_revisor', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = il.exame_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
//        $this->db->where('il.exame_id', $agenda_exames_id);
        $this->db->where("((il.laudo_status = 'PUBLICADO') OR (il.laudo_status = 'REPUBLICADO') ) ");
        $return = $this->db->get();
        return $return->result();
    }

    function listardadoslaudogravarxml($ambulatorio_laudo_id) {
        $this->db->select('al.ambulatorio_laudo_id, al.exame_id, e.sala_id');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->join('tb_exames e', 'e.exames_id = al.exame_id');
        $this->db->where('al.ambulatorio_laudo_id', $ambulatorio_laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function atualizacaolaudosintegracaotodos() {

        $this->db->select('il.integracao_laudo_id,
                            il.exame_id,
                            il.laudo_texto,
                            il.laudo_data_hora,
                            al.ambulatorio_laudo_id,
                            il.laudo_status,
                            al.ambulatorio_laudo_id,
                            o.operador_id as medico,
                            op.operador_id as revisor');
        $this->db->from('tb_integracao_laudo il');
        $this->db->join('tb_operador o', 'o.conselho = il.laudo_conselho_medico', 'left');
        $this->db->join('tb_operador op', 'op.conselho = il.laudo_conselho_medico_revisor', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = il.exame_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
//        $this->db->where('il.exame_id', $agenda_exames_id);
        $this->db->where("((il.laudo_status = 'PUBLICADO') OR (il.laudo_status = 'REPUBLICADO') ) ");
        $this->db->orderby('il.laudo_status');
        $this->db->orderby('il.integracao_laudo_id');
        $query = $this->db->get();
        $return = $query->result();

        $laudosInseridos = array();

        foreach ($return as $value) {
            $laudosInseridos[] = $value->ambulatorio_laudo_id;

            $laudo_texto = $value->laudo_texto;
            $laudo_data_hora = $value->laudo_data_hora;
            $ambulatorio_laudo_id = $value->ambulatorio_laudo_id;
            $medico = $value->medico;
            $revisor = $value->revisor;
            $agenda_exames_id = $value->exame_id;
            $this->db->set('texto', $laudo_texto);
            $this->db->set('situacao', 'FINALIZADO');
            $this->db->set('medico_parecer1', $medico);
            $this->db->set('medico_parecer2', $revisor);
            $this->db->set('data_atualizacao', $laudo_data_hora);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');

            $this->db->set('medico_consulta_id', $medico);
            $this->db->where('agenda_exames_id', $agenda_exames_id);
            $this->db->update('tb_agenda_exames');

            $this->db->set('laudo_status', 'LIDO');
            $this->db->where('exame_id', $agenda_exames_id);
            $this->db->update('tb_integracao_laudo');
        }

        return $laudosInseridos;
//
//
//        $this->db->select('il.integracao_laudo_id,
//                            il.exame_id,
//                            il.laudo_texto,
//                            il.laudo_data_hora,
//                            al.ambulatorio_laudo_id,
//                            il.laudo_status,
//                            al.ambulatorio_laudo_id,
//                            o.operador_id as medico,
//                            op.operador_id as revisor');
//        $this->db->from('tb_integracao_laudo il');
//        $this->db->join('tb_operador o', 'o.conselho = il.laudo_conselho_medico', 'left');
//        $this->db->join('tb_operador op', 'op.conselho = il.laudo_conselho_medico_revisor', 'left');
//        $this->db->join('tb_exames e', 'e.agenda_exames_id = il.exame_id', 'left');
//        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
////        $this->db->where('il.exame_id', $agenda_exames_id);
//        $this->db->where('il.laudo_status', 'REPUBLICADO');
//        $this->db->orderby('il.integracao_laudo_id');
//        $query = $this->db->get();
//        $return = $query->result();
//
//        foreach ($return as $value) {
//            $laudo_texto = $value->laudo_texto;
//            $laudo_data_hora = $value->laudo_data_hora;
//            $ambulatorio_laudo_id = $value->ambulatorio_laudo_id;
//            $medico = $value->medico;
//            $revisor = $value->revisor;
//            $agenda_exames_id = $value->exame_id;
//            $this->db->set('texto', $laudo_texto);
//            $this->db->set('situacao', 'FINALIZADO');
//            $this->db->set('medico_parecer1', $medico);
//            $this->db->set('medico_parecer2', $revisor);
//            $this->db->set('data_atualizacao', $laudo_data_hora);
//            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
//            $this->db->update('tb_ambulatorio_laudo');
//
//            $this->db->set('medico_consulta_id', $medico);
//            $this->db->where('agenda_exames_id', $agenda_exames_id);
//            $this->db->update('tb_agenda_exames');
//
//            $this->db->set('laudo_status', 'LIDO');
//            $this->db->where('exame_id', $agenda_exames_id);
//            $this->db->update('tb_integracao_laudo');
//        }
    }

    function email($paciente_id) {

        $this->db->select('cns');
        $this->db->from('tb_paciente');
        $this->db->where('paciente_id', $paciente_id);
        $return = $this->db->get();
        $result = $return->result();

        return $result[0]->cns;
    }

    function listarempresatipoxml() {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('t.nome, e.impressao_tipo');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_empresa_tipo_xml t', 't.tipo_xml_id = e.tipo_xml_id', 'left');
        $this->db->where("t.ativo", 't');
        $this->db->where("e.ativo", 't');
        $this->db->where("e.empresa_id", $empresa_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listaradcl($args = array()) {
        $this->db->select('oad.ad_cilindrico_id,oad.numero, oad.nome ');
        $this->db->from('tb_oftamologia_ad_cilindrico oad');
        $this->db->where('oad.ativo ', 't');
        $this->db->orderby('oad.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function listarades($args = array()) {
        $this->db->select('oad.ad_esferico_id,oad.numero, oad.nome ');
        $this->db->from('tb_oftamologia_ad_esferico oad');
        $this->db->where('oad.ativo ', 't');
        $this->db->orderby('oad.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function listarodcl($args = array()) {
        $this->db->select('ood.od_cilindrico_id,ood.numero, ood.nome ');
        $this->db->from('tb_oftamologia_od_cilindrico ood');
        $this->db->where('ood.ativo ', 't');
        $this->db->orderby('ood.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function listarodes($args = array()) {
        $this->db->select('ood.od_esferico_id,ood.numero, ood.nome ');
        $this->db->from('tb_oftamologia_od_esferico ood');
        $this->db->where('ood.ativo ', 't');
        $this->db->orderby('ood.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function listarodeixo($args = array()) {
        $this->db->select('ood.od_eixo_id,ood.numero, ood.nome ');
        $this->db->from('tb_oftamologia_od_eixo ood');
        $this->db->where('ood.ativo ', 't');
        $this->db->orderby('ood.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function listarodav($args = array()) {
        $this->db->select('ood.od_av_id,ood.numero, ood.nome ');
        $this->db->from('tb_oftamologia_od_av ood');
        $this->db->where('ood.ativo ', 't');
        $this->db->orderby('ood.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function listaroecl($args = array()) {
        $this->db->select('ooe.oe_cilindrico_id,ooe.numero, ooe.nome ');
        $this->db->from('tb_oftamologia_oe_cilindrico ooe');
        $this->db->where('ooe.ativo ', 't');
        $this->db->orderby('ooe.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function listaroees($args = array()) {
        $this->db->select('ooe.oe_esferico_id,ooe.numero, ooe.nome ');
        $this->db->from('tb_oftamologia_oe_esferico ooe');
        $this->db->where('ooe.ativo ', 't');
        $this->db->orderby('ooe.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function listaroeeixo($args = array()) {
        $this->db->select('ooe.oe_eixo_id,ooe.numero, ooe.nome ');
        $this->db->from('tb_oftamologia_oe_eixo ooe');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ooe.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('ooe.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('ooe.ativo ', 't');
        $this->db->orderby('ooe.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function listaroeav($args = array()) {
        $this->db->select('ooe.oe_av_id,ooe.numero, ooe.nome ');
        $this->db->from('tb_oftamologia_oe_av ooe');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('ooe.numero ilike', "%" . $args['nome'] . "%");
            $this->db->orwhere('ooe.nome ilike', "%" . $args['nome'] . "%");
        }
        $this->db->where('ooe.ativo ', 't');
        $this->db->orderby('ooe.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function listaracuidadeod($args = array()) {
        $this->db->select('oad.od_acuidade_id,oad.numero, oad.nome ');
        $this->db->from('tb_oftamologia_od_acuidade oad');
        $this->db->where('oad.ativo ', 't');
        $this->db->orderby('oad.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listaracuidadeoe($args = array()) {
        $this->db->select('oad.oe_acuidade_id,oad.numero, oad.nome ');
        $this->db->from('tb_oftamologia_oe_acuidade oad');
        $this->db->where('oad.ativo ', 't');
        $this->db->orderby('oad.nome ');
        $return = $this->db->get();
        return $return->result();
    }

    function listar($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.situacao,
                            ag.situacao_revisor,
                            o.nome as medico,
                            age.procedimento_tuss_id,
                            op.nome as medicorevisor,
                            age.agenda_exames_nome_id,
                            ag.data_cadastro,
                            p.idade,
                            ag.medico_parecer2,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = age.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where("ag.cancelada", 'false');
        $this->db->where('age.sala_preparo', 'f');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ag.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }

        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('age.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['exame_id']) && strlen($args['exame_id']) > 0) {
            $this->db->where('age.agenda_exames_id', $args['exame_id']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ag.medico_parecer1', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ag.situacao', $args['situacao']);
        }
        if (isset($args['medicorevisor']) && strlen($args['medicorevisor']) > 0) {
            $this->db->where('ag.medico_parecer2', $args['medicorevisor']);
        }
        if (isset($args['situacaorevisor']) && strlen($args['situacaorevisor']) > 0) {
            $this->db->where('ag.situacao_revisor', $args['situacaorevisor']);
        }
        return $this->db;
    }

    function listar2($args = array()) {
        $data = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');

        $contador = count($args);
        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.situacao,
                            ag.situacao_revisor,
                            o.nome as medico,
                            age.procedimento_tuss_id,
                            op.nome as medicorevisor,
                            pt.nome as procedimento,
                            p.idade,
                            p.nascimento,
                            ag.medico_parecer1,
                            ae.guia_id,
                            ae.agenda_exames_id,
                            ag.data_cadastro,
                            pt.grupo,
                            age.agenda_exames_nome_id,
                            ag.medico_parecer2,
                            p.nome as paciente,
                            c.nome as convenio,
                            ag.data_antiga');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where('pt.grupo !=', 'LABORATORIAL');
        $this->db->where("ag.cancelada", 'false');
        $this->db->where('age.sala_preparo', 'f');
        $this->db->orderby('ag.data_cadastro desc');
        $this->db->orderby('ag.situacao');
        $this->db->orderby('ag.data_cadastro');
        if ($contador == 0) {
            $this->db->where('ag.data >=', $data);
        }
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ag.data', $args['data']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('age.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['exame_id']) && strlen($args['exame_id']) > 0) {
            $this->db->where('age.agenda_exames_id', $args['exame_id']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ag.medico_parecer1', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ag.situacao', $args['situacao']);
        }
        if (isset($args['medicorevisor']) && strlen($args['medicorevisor']) > 0) {
            $this->db->where('ag.medico_parecer2', $args['medicorevisor']);
        }
        if (isset($args['situacaorevisor']) && strlen($args['situacaorevisor']) > 0) {
            $this->db->where('ag.situacao_revisor', $args['situacaorevisor']);
        }
        return $this->db;
    }

    function listarconsulta($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.situacao,
                            ag.situacao_revisor,
                            o.nome as medico,
                            age.procedimento_tuss_id,
                            op.nome as medicorevisor,
                            age.agenda_exames_nome_id,
                            ag.data_cadastro,
                            p.idade,
                            ag.medico_parecer2,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = age.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->where('ag.empresa_id', $empresa_id);
        $this->db->where('pt.grupo', 'CONSULTA');
        $this->db->where("ag.cancelada", 'false');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ag.data', $args['data']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('age.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['exame_id']) && strlen($args['exame_id']) > 0) {
            $this->db->where('age.agenda_exames_id', $args['exame_id']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ag.medico_parecer1', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ag.situacao', $args['situacao']);
        }
        if (isset($args['medicorevisor']) && strlen($args['medicorevisor']) > 0) {
            $this->db->where('ag.medico_parecer2', $args['medicorevisor']);
        }
        if (isset($args['situacaorevisor']) && strlen($args['situacaorevisor']) > 0) {
            $this->db->where('ag.situacao_revisor', $args['situacaorevisor']);
        }
        return $this->db;
    }

    function listar2consulta($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.situacao,
                            ag.situacao_revisor,
                            o.nome as medico,
                            age.procedimento_tuss_id,
                            op.nome as medicorevisor,
                            pt.nome as procedimento,
                            p.idade,
                            p.nascimento,
                            ag.medico_parecer1,
                            ae.guia_id,
                            ae.exames_id,
                            ae.sala_id,
                            ae.agenda_exames_id,
                            c.nome as convenio,
                            ag.data_cadastro,
                            age.agenda_exames_nome_id,
                            ag.medico_parecer2,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->where('ag.empresa_id', $empresa_id);
        $this->db->where('pt.grupo', 'CONSULTA');
        $this->db->where("ag.cancelada", 'false');
        $this->db->orderby('ag.data_cadastro desc');
        $this->db->orderby('ag.situacao');
        $this->db->orderby('ag.data_cadastro');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ag.data', $args['data']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('age.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['exame_id']) && strlen($args['exame_id']) > 0) {
            $this->db->where('age.agenda_exames_id', $args['exame_id']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ag.medico_parecer1', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ag.situacao', $args['situacao']);
        }
        if (isset($args['medicorevisor']) && strlen($args['medicorevisor']) > 0) {
            $this->db->where('ag.medico_parecer2', $args['medicorevisor']);
        }
        if (isset($args['situacaorevisor']) && strlen($args['situacaorevisor']) > 0) {
            $this->db->where('ag.situacao_revisor', $args['situacaorevisor']);
        }
        return $this->db;
    }

    function listarconsultahistorico($paciente_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.data_cadastro,
                            ag.situacao,
                            o.nome as medico,
                            ag.texto,
                            age.procedimento_tuss_id,
                            pt.nome as procedimento,
                            ag.medico_parecer1,
                            ae.agenda_exames_id,
                            c.nome as convenio,
                            age.agenda_exames_nome_id,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo agr', 'agr.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->where('age.paciente_id', $paciente_id);
//        $this->db->where('ag.empresa_id', $empresa_id);
        $this->db->where('agr.tipo', 'CONSULTA');
        $this->db->where("ag.cancelada", 'false');
        $this->db->orderby('ag.data_cadastro desc');
        $this->db->orderby('ag.situacao');
        $this->db->orderby('ag.data_cadastro');
        $return = $this->db->get()->result();
//        echo '<pre>';
//        var_dump($return); die;
        return $return;
    }

    function listarxmllaudo($args = array()) {
//        var_dump($_POST['convenio'] , $_POST['medico'],$_POST['paciente']);
//        die;

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('pt.codigo , g.ambulatorio_guia_id,
                            ae.valor_total,
                            ae.valor,
                            ae.autorizacao,
                            p.convenionumero,
                            p.nome as paciente,
                            p.nascimento,
                            op.nome as medicosolicitante,
                            op.conselho as conselhosolicitante,
                            o.nome as medico,
                            o.conselho,
                            o.cbo_ocupacao_id,
                            o.cpf,
                            ae.data_autorizacao,
                            ae.data_realizacao,                            
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
                            g.guiaconvenio,
                            ae.paciente_id,
                            al.texto_laudo,
                            al.ambulatorio_laudo_id,
                            i.wkl_accnumber,
                            i.wkl_procstep_descr');
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
        $this->db->join('tb_integracao_naja i', 'i.wkl_exame_id = ae.agenda_exames_id', 'left');
        $this->db->where("c.dinheiro", 'f');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.cancelada', 'false');
        if (isset($_POST['datainicio']) && strlen($_POST['datainicio']) > 0) {
            $this->db->where('ae.data >=', $_POST['datainicio']);
        }
        if ($_POST['empresa'] != "0") {
            $this->db->where('ae.empresa_id', $_POST['empresa']);
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
        if (isset($_POST['paciente_id']) && $_POST['paciente_id'] != "") {
            $this->db->where('p.paciente_id', $_POST['paciente_id']);
        }
        $return = $this->db->get();

//        var_dump($return->result());
//        die;
        return $return->result();
    }

    function listarxmlsalvar($ambulatorio_laudo_id, $exame_id, $sala_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('pt.codigo , g.ambulatorio_guia_id,
                            ae.valor_total,
                            ae.valor,
                            ae.autorizacao,
                            an.nome as sala, 
                            p.convenionumero,
                            p.nome as paciente,
                            p.nascimento,
                            p.sexo,
                            p.paciente_id,
                            op.nome as medicosolicitante,
                            op.conselho as conselhosolicitante,
                            o.nome as medico,
                            o.conselho,
                            o.cbo_ocupacao_id,
                            o.cpf,
                            ae.data_autorizacao,
                            ae.data_realizacao,                            
                            tu.descricao as procedimento,
                            al.data,
                            al.medico_parecer1,
                            al.medico_parecer2,
                            pt.grupo,
                            c.nome as convenio,
                            tuc.nome as classificacao,
                            ae.quantidade,
                            c.registroans,
                            c.convenio_pasta,
                            c.codigoidentificador,
                            e.data_cadastro,
                            e.data_atualizacao,
                            g.data_criacao,
                            ae.guiaconvenio,
                            ae.paciente_id,
                            al.situacao,
                            al.texto_laudo,
                            al.texto,
                            al.ambulatorio_laudo_id,
                            i.wkl_accnumber,
                            i.wkl_procstep_descr');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->join('tb_exames e', 'e.exames_id= al.exame_id', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_guia g', 'ae.guia_id = g.ambulatorio_guia_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_tuss tu', 'tu.tuss_id = pt.tuss_id', 'left');
        $this->db->join('tb_tuss_classificacao tuc', 'tuc.tuss_classificacao_id = tu.classificacao', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
//        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_integracao_naja i', 'i.wkl_exame_id = ae.agenda_exames_id', 'left');
        $this->db->where("c.dinheiro", 'f');
        $this->db->where('ae.ativo', 'false');
        $this->db->where('ae.cancelada', 'false');
//        $this->db->where('an.exame_sala_id', $sala_id);
//        $this->db->where('e.exames_id', $exame_id);
        $this->db->where('al.ambulatorio_laudo_id', $ambulatorio_laudo_id);
        $return = $this->db->get();

        return $return->result();
    }

    function chamarpacientesalaespera($agenda_exames_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select(' o.nome as medico,
                            an.exame_sala_id,
                            cbo.descricao,
                            o.ocupacao_painel,
                            e.numero_empresa_painel,
                            p.nome as paciente');
        $this->db->from('tb_agenda_exames ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ag.agenda_exames_nome_id', 'left');
        $this->db->join('tb_empresa e', 'e.empresa_id = an.empresa_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_consulta_id', 'left');
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = o.cbo_ocupacao_id', 'left');
        $this->db->where('ag.agenda_exames_id', $agenda_exames_id);
        $return = $this->db->get()->result();


        $this->db->select(' nome_chamada,
                            painel_id');
        $this->db->from('tb_exame_sala_painel');
        $this->db->where('exame_sala_id', $return[0]->exame_sala_id);
        $this->db->where('ativo', 't');
        $paineis = $this->db->get()->result();

        $config['hostname'] = "localhost";
        $config['username'] = "postgres";
        $config['password'] = "123456";
        $config['database'] = "painelWeb";
        $config['dbdriver'] = "postgre";
        $config['dbprefix'] = "public.";
        $config['pconnect'] = FALSE;
        $config['db_debug'] = TRUE;
        $config['active_r'] = TRUE;
        $config['cachedir'] = "";
        $config['char_set'] = "utf8";
        $config['dbcollat'] = "utf8_general_ci";
        $DB1 = $this->load->database($config, TRUE);

        foreach ($paineis as $value) {
            $salas = $value->nome_chamada;
            $data = date("Y-m-d H:i:s");
            if ($return[0]->ocupacao_painel == 't') {
                $medico = $return[0]->descricao;
            } else {
                $medico = '';
            }
//            var_dump($medico); die;

            if ($value->painel_id != '') {
                $painel_id = $return[0]->numero_empresa_painel . $value->painel_id;
            } else {
                $painel_id = $return[0]->numero_empresa_painel . 1;
            }

            $paciente = $return[0]->paciente;
            $superior = 'Paciente: ' . $paciente;
            $inferior = $salas . ' ' . $medico;
            $sql = "INSERT INTO chamado(
                data, linha_inferior, linha_superior, setor_id)
        VALUES ('$data', '$inferior', '$superior', $painel_id);";
            $DB1->query($sql);
        }
    }

    function chamada($ambulatorio_laudo_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudo_id,
                            o.nome as medico,
                            ag.medico_parecer1,
                            o.ocupacao_painel,
                            an.exame_sala_id,
                            cbo.descricao,
                            p.nome as paciente,
                            p.cpf,
                            e.numero_empresa_painel,
                            ag.idfila_painel');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = age.agenda_exames_nome_id', 'left');
        $this->db->join('tb_empresa e', 'e.empresa_id = an.empresa_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = o.cbo_ocupacao_id', 'left');
        $this->db->where('ag.ambulatorio_laudo_id', $ambulatorio_laudo_id);
        $return = $this->db->get()->result();


        $this->db->select(' nome_chamada,
                            painel_id');
        $this->db->from('tb_exame_sala_painel');
        $this->db->where('exame_sala_id', $return[0]->exame_sala_id);
        $this->db->where('ativo', 't');
        $paineis = $this->db->get()->result();

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('endereco_toten');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa_id);
        $dados = $this->db->get()->result();

        if ($dados[0]->endereco_toten != '') {
            if ($return[0]->idfila_painel == '') {
                $this->db->select('id');
                $this->db->from('tb_toten_senha');
                $this->db->where('chamada', 'f');
                $paineis = $this->db->get()->result();
                $idfila = $paineis[0]->id;
            } else {
                $idfila = $return[0]->idfila_painel;
            }

            $endereco = $dados[0]->endereco_toten . "/webService/telaAtendimento/enviarFicha/";
            $endereco .= "{$idfila}/{$return[0]->paciente}/null/{$return[0]->medico_parecer1}/{$return[0]->medico}/{$return[0]->exame_sala_id}/true";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endereco);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array());
            $result = curl_exec($ch);
            curl_close($ch);

            $endereco = $dados[0]->endereco_toten . "/webService/telaChamado/proximo/{$return[0]->medico_parecer1}";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endereco);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array());
            $result = curl_exec($ch);
            curl_close($ch);
        } else {
            $config['hostname'] = "localhost";
            $config['username'] = "postgres";
            $config['password'] = "123456";
            $config['database'] = "painelWeb";
            $config['dbdriver'] = "postgre";
            $config['dbprefix'] = "public.";
            $config['pconnect'] = FALSE;
            $config['db_debug'] = TRUE;
            $config['active_r'] = TRUE;
            $config['cachedir'] = "";
            $config['char_set'] = "utf8";
            $config['dbcollat'] = "utf8_general_ci";
            $DB1 = $this->load->database($config, TRUE);

            foreach ($paineis as $value) {
                $salas = $value->nome_chamada;
                $data = date("Y-m-d H:i:s");
                if ($return[0]->ocupacao_painel == 't') {
                    $medico = $return[0]->descricao;
                } else {
                    $medico = '';
                }
                //            var_dump($medico); die;
                if ($value->painel_id != '') {
                    $painel_id = $return[0]->numero_empresa_painel . $value->painel_id;
                } else {
                    $painel_id = $return[0]->numero_empresa_painel . 1;
                }

                $paciente = $return[0]->paciente;
                $superior = 'Paciente: ' . $paciente;
                $inferior = $salas . ' ' . $medico;
                $sql = "INSERT INTO chamado(
                    data, linha_inferior, linha_superior, setor_id)
            VALUES ('$data', '$inferior', '$superior', $painel_id);";
                $DB1->query($sql);
            }
        }
    }

    function chamadaconsulta($ambulatorio_laudo_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudo_id,
                            o.nome as medico,
                            o.ocupacao_painel,
                            an.exame_sala_id,
                            cbo.descricao,
                            p.nome as paciente,
                            e.numero_empresa_painel');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = age.agenda_exames_nome_id', 'left');
        $this->db->join('tb_empresa e', 'e.empresa_id = an.empresa_id');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = o.cbo_ocupacao_id', 'left');
        $this->db->where('ag.ambulatorio_laudo_id', $ambulatorio_laudo_id);
        $return = $this->db->get()->result();

        $this->db->select(' nome_chamada,
                            painel_id');
        $this->db->from('tb_exame_sala_painel');
        $this->db->where('exame_sala_id', $return[0]->exame_sala_id);
        $this->db->where('ativo', 't');
        $paineis = $this->db->get()->result();


        $config['hostname'] = "localhost";
        $config['username'] = "postgres";
        $config['password'] = "123456";
        $config['database'] = "painelWeb";
        $config['dbdriver'] = "postgre";
        $config['dbprefix'] = "public.";
        $config['pconnect'] = FALSE;
        $config['db_debug'] = TRUE;
        $config['active_r'] = TRUE;
        $config['cachedir'] = "";
        $config['char_set'] = "utf8";
        $config['dbcollat'] = "utf8_general_ci";
        $DB1 = $this->load->database($config, TRUE);
//            $DB1 = $this->load->database('group_one', TRUE);
        foreach ($paineis as $value) {
            $salas = $value->nome_chamada;
            $data = date("Y-m-d H:i:s");
            if ($return[0]->ocupacao_painel == 't') {
                $medico = $return[0]->descricao;
            } else {
                $medico = '';
            }
            if ($value->painel_id != '') {
                $painel_id = $return[0]->numero_empresa_painel . $value->painel_id;
            } else {
                $painel_id = $return[0]->numero_empresa_painel . 1;
            }

            $paciente = $return[0]->paciente;
            $superior = 'Paciente: ' . $paciente;
            $inferior = $salas . ' ' . $medico;
            $sql = "INSERT INTO chamado(
                data, linha_inferior, linha_superior, setor_id)
        VALUES ('$data', '$inferior', '$superior', $painel_id);";
            $DB1->query($sql);
        }
    }

    function editaranaminesehistorico() {
        $this->db->set('laudo', $_POST['laudo']);
        $this->db->where('laudoantigo_id', $_POST['laudoantigo_id']);
        $this->db->update('tb_laudoantigo');
    }

    function listarconsultahistoricoantigoeditar($laudoantigo_id) {

        $this->db->select('laudo, data_cadastro, laudoantigo_id, paciente_id');
        $this->db->from('tb_laudoantigo');
        $this->db->where('laudoantigo_id', $laudoantigo_id);
//        $this->db->orderby('data_cadastro desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarconsultahistoricoantigo($paciente_id) {

        $this->db->select('laudo, data_cadastro, laudoantigo_id, paciente_id');
        $this->db->from('tb_laudoantigo');
        $this->db->where('paciente_id', $paciente_id);
        $this->db->orderby('data_cadastro desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarhistoricoantigo2($args = array()) {

        $this->db->select('distinct(la.paciente_id), p.nome as paciente');
        $this->db->from('tb_laudoantigo la');
        $this->db->join('tb_paciente p', 'p.paciente_id = la.paciente_id', 'left');
//        $this->db->where('p.nome ', null);
        $this->db->orderby('p.nome');
        if (isset($args['prontuario']) && strlen($args['prontuario']) > 0) {
            $this->db->where('la.paciente_id ', $args['prontuario']);
        }
        if (isset($args['paciente'])) {

            $this->db->where('p.nome ilike', '%' . $args['paciente'] . '%');
        }
        return $this->db;
    }

    function listarhistoricoantigo($args = array()) {

        $this->db->select('distinct(la.paciente_id)');
        $this->db->from('tb_laudoantigo la');
        $this->db->join('tb_paciente p', 'p.paciente_id = la.paciente_id', 'left');
//        $this->db->where('p.nome ', null);
        if (isset($args['prontuario']) && strlen($args['prontuario']) > 0) {
            $this->db->where('la.paciente_id ', $args['prontuario']);
        }
        if (isset($args['paciente'])) {
            $this->db->where('p.nome ilike', '%' . $args['paciente'] . '%');
        }
        return $this->db;
    }

    function listarnomeendoscopia() {

        $this->db->select('nome');
        $this->db->from('tb_ambulatorio_nome_endoscopia');
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorimagem($exame_id, $sequencia) {

        $this->db->select('nome');
        $this->db->from('tb_ambulatorio_nome_endoscopia_imagem');
        $this->db->where('exame_id', $exame_id);
        $this->db->where('ambulatorio_nome_endoscopia', $sequencia);
        $return = $this->db->get();
        return $return->result();
    }

    function deletarregistroimagem($exame_id, $imagem_id) {

        $this->db->where('exame_id', $exame_id);
        $this->db->where('ambulatorio_nome_endoscopia', $imagem_id);
        $this->db->delete('tb_ambulatorio_nome_endoscopia_imagem');
        $erro = $this->db->_error_message();
    }

    function deletarnomesimagens($exame_id) {

        $this->db->where('exame_id', $exame_id);
        $this->db->delete('tb_ambulatorio_nome_endoscopia_imagem');
    }

    function contadorimagem2($exame_id, $imagem_id) {

        $this->db->select('nome');
        $this->db->from('tb_ambulatorio_nome_endoscopia_imagem');
        $this->db->where('exame_id', $exame_id);
        $this->db->where('ambulatorio_nome_endoscopia', $imagem_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarnomeimagem($exame_id) {

        $this->db->select('nome');
        $this->db->from('tb_ambulatorio_nome_endoscopia_imagem');
        $this->db->where('exame_id', $exame_id);
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function gravarnome($exame_id, $imagem_id, $novonome, $sequencia) {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', trim($novonome));
            $this->db->set('exame_id', $exame_id);
            $this->db->set('ambulatorio_nome_endoscopia', $sequencia);
            $this->db->insert('tb_ambulatorio_nome_endoscopia_imagem');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function alterarnome($exame_id, $imagem_id, $novonome, $sequencia) {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('nome', trim($novonome));
            $this->db->set('ambulatorio_nome_endoscopia', $sequencia);
            $this->db->where('exame_id', $exame_id);
            $this->db->where('ambulatorio_nome_endoscopia', trim($_POST['imagem_id']));
            $this->db->update('tb_ambulatorio_nome_endoscopia_imagem');

            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarreceitahistorico($paciente_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('al.ambulatorio_laudo_id,
                            ag.data_cadastro,
                            o.nome as medico,
                            ag.texto,
                            age.procedimento_tuss_id,
                            pt.nome as procedimento,
                            ag.medico_parecer1,
                            ae.agenda_exames_id,
                            age.agenda_exames_nome_id,
                            p.nome as paciente,
                            ag.ambulatorio_receituario_id,
                            ag.texto,
                            ag.data_cadastro,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_receituario ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.ambulatorio_laudo_id = ag.laudo_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = al.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->where('ag.paciente_id', $paciente_id);
        $this->db->where('ag.empresa_id', $empresa_id);
        $this->db->orderby('ag.data_cadastro desc');
        $this->db->orderby('ag.data_cadastro');
        $return = $this->db->get();
        return $return->result();
    }

    function listarreceita($paciente_id) {

        $this->db->select(' ag.ambulatorio_receituario_id,
                            ag.texto,
                            ag.data_cadastro,
                            ag.medico_parecer1,
                            al.cabecalho,
                            o.nome as medico,
                            o.operador_id,
                            pt.nome as procedimento
                            ');
        $this->db->from('tb_ambulatorio_receituario ag');
        $this->db->join('tb_ambulatorio_laudo al', 'al.ambulatorio_laudo_id = ag.laudo_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = al.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->where('al.paciente_id', $paciente_id);
        $this->db->where('ag.tipo', 'NORMAL');
        $this->db->orderby('ag.data_cadastro DESC');

        $return = $this->db->get();
        return $return->result();
    }

    function listareditarreceita($ambulatorio_laudo_id) {

        $this->db->select(' ag.ambulatorio_receituario_id ,
                            ag.texto,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_receituario ag');
        $this->db->where('ag.ambulatorio_receituario_id', $ambulatorio_laudo_id);
        $this->db->where('ag.tipo', 'NORMAL');
        $return = $this->db->get();
        return $return->result();
    }

    function listarrepetirreceita($ambulatorio_laudo_id) {

        $this->db->select(' ag.ambulatorio_receituario_id ,
                            ag.data_cadastro,
                            ag.texto,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_receituario ag');
        $this->db->where('ag.ambulatorio_receituario_id', $ambulatorio_laudo_id);
        $this->db->where('ag.tipo', 'NORMAL');
        $return = $this->db->get();
        return $return->result();
    }

    function listaratestado($ambulatorio_laudo_id) {

        $this->db->select(' ag.ambulatorio_atestado_id,
                            ag.texto,
                            ag.data_cadastro,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_atestado ag');
        $this->db->where('ag.laudo_id', $ambulatorio_laudo_id);
        $this->db->where('ag.tipo', 'NORMAL');
        $this->db->orderby('ag.data_cadastro DESC');
        $return = $this->db->get();
        return $return->result();
    }

    function listareditaratestado($ambulatorio_laudo_id) {

        $this->db->select(' ag.ambulatorio_atestado_id ,
                            ag.texto,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_atestado ag');
        $this->db->where('ag.ambulatorio_atestado_id', $ambulatorio_laudo_id);
        $this->db->where('ag.tipo', 'NORMAL');
        $return = $this->db->get();
        return $return->result();
    }

    function listarexame($ambulatorio_laudo_id) {

        $this->db->select(' ag.ambulatorio_exame_id,
                            ag.texto,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_exame ag');
        $this->db->where('ag.laudo_id', $ambulatorio_laudo_id);
        $this->db->where('ag.tipo', 'NORMAL');
        $this->db->orderby('ambulatorio_exame_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listareditarexame($ambulatorio_laudo_id) {

        $this->db->select(' ag.ambulatorio_exame_id ,
                            ag.texto,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_exame ag');
        $this->db->where('ag.ambulatorio_exame_id', $ambulatorio_laudo_id);
        $this->db->where('ag.tipo', 'NORMAL');
        $return = $this->db->get();
        return $return->result();
    }

    function listarlaudoemailencaminhamento($ambulatorio_laudo_id) {


        $this->db->select('o.nome as medico,
                            o.email');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->where("ag.ambulatorio_laudo_id", $ambulatorio_laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarmedicoenviarencaminhamento($medico_id) {


        $this->db->select('o.nome as medico,
                            o.email');
        $this->db->from('tb_operador o');
        $this->db->where("o.operador_id", $medico_id);
        $return = $this->db->get();
        return $return->result();
    }

    function contadorlistarreceita($ambulatorio_laudo_id) {

        $this->db->select(' ag.texto,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_receituario ag');
        $this->db->where('ag.laudo_id', $ambulatorio_laudo_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarreceitasespeciais($ambulatorio_laudo_id) {

        $this->db->select(' ag.ambulatorio_receituario_especial_id ,
                            ag.texto,
                            ag.data_cadastro,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_receituario_especial ag');
        $this->db->where('ag.laudo_id', $ambulatorio_laudo_id);
        $this->db->where('ag.tipo', 'ESPECIAL');
        $this->db->orderby('ag.data_cadastro DESC');
        $return = $this->db->get();
        return $return->result();
    }

    function listarreceitaespecial($ambulatorio_laudo_id) {

        $this->db->select(' ag.ambulatorio_receituario_especial_id ,
                            ag.texto,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_receituario_especial ag');
        $this->db->where('ag.ambulatorio_receituario_especial_id', $ambulatorio_laudo_id);
        $this->db->where('ag.tipo', 'ESPECIAL');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorlistarreceitaespecial($ambulatorio_laudo_id) {

        $this->db->select(' ag.texto,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_receituario_especial ag');
        $this->db->where('ag.laudo_id', $ambulatorio_laudo_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarexamehistorico($paciente_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.data_cadastro,
                            ag.situacao,
                            o.nome as medico,
                            ag.texto,
                            ae.exames_id,
                            age.procedimento_tuss_id,
                            pt.nome as procedimento,
                            ag.medico_parecer1,
                            ae.agenda_exames_id,
                            age.agenda_exames_nome_id,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_ambulatorio_grupo agr', 'agr.nome = pt.grupo', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->where('ae.paciente_id', $paciente_id);
//        $this->db->where('ag.empresa_id', $empresa_id);
        $this->db->where('agr.tipo !=', 'CONSULTA');
        $this->db->where("ag.cancelada", 'false');
        $this->db->orderby('ag.data_cadastro desc');
        $this->db->orderby('ag.situacao');
        $this->db->orderby('ag.data_cadastro');
        $return = $this->db->get();
        return $return->result();
    }

    function listardigitador($args = array(), $medico_laudodigitador) {

        $empresa_id = $this->session->userdata('empresa_id');
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');

        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.situacao,
                            ag.situacao_revisor,
                            o.nome as medico,
                            age.procedimento_tuss_id,
                            op.nome as medicorevisor,
                            age.agenda_exames_nome_id,
                            ag.data_cadastro,
                            p.idade,
                            ag.medico_parecer2,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = age.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador ope', 'ope.operador_id = age.operador_recebido', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->where('ag.empresa_id', $empresa_id);
        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where("ag.cancelada", 'false');
        $this->db->where('age.sala_preparo', 'f');


        if ($perfil_id == 4 && $medico_laudodigitador == 'f') {
            $this->db->where('age.medico_consulta_id', $operador_id);
        }

        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ag.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('age.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['paciente_id']) && strlen($args['paciente_id']) > 0) {
            $this->db->where('ag.paciente_id', $args['paciente_id']);
        }
        if (isset($args['exame_id']) && strlen($args['exame_id']) > 0) {
            $this->db->where('ag.guia_id', $args['exame_id']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ag.medico_parecer1', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ag.situacao', $args['situacao']);
        }
        if (isset($args['medicorevisor']) && strlen($args['medicorevisor']) > 0) {
            $this->db->where('ag.medico_parecer2', $args['medicorevisor']);
        }
        if (isset($args['situacaorevisor']) && strlen($args['situacaorevisor']) > 0) {
            $this->db->where('ag.situacao_revisor', $args['situacaorevisor']);
        }
        return $this->db;
    }

    function listar2digitador($args = array(), $medico_laudodigitador) {
        $data = date("Y-m-d");
        $contador = count($args);
        $empresa_id = $this->session->userdata('empresa_id');
        $operador_id = $this->session->userdata('operador_id');
        $perfil_id = $this->session->userdata('perfil_id');

        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.situacao,
                            ag.situacao_revisor,
                            o.nome as medico,
                            age.procedimento_tuss_id,
                            op.nome as medicorevisor,
                            pt.nome as procedimento,
                            p.idade,
                            ae.sala_id,
                            age.entregue,
                            age.recebido,
                            age.data_recebido,
                            age.data_entregue,
                            age.entregue_telefone,
                            ope.nome as operadorrecebido,
                            ae.exames_id,
                            ag.medico_parecer1,
                            ae.guia_id,
                            ae.agenda_exames_id,
                            ag.data_atualizacao,
                            age.agenda_exames_nome_id,
                            ag.medico_parecer2,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = age.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador ope', 'ope.operador_id = age.operador_recebido', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->where('ag.empresa_id', $empresa_id);
        $this->db->where('pt.grupo !=', 'CONSULTA');
        $this->db->where("ag.cancelada", 'false');
        $this->db->where('age.sala_preparo', 'f');
        $this->db->orderby('ag.situacao');
        $this->db->orderby('ag.data_cadastro');
        if ($contador == 0) {
            $this->db->where('ag.data >=', $data);
        }

        if ($perfil_id == 4 && $medico_laudodigitador == 'f') {
            $this->db->where('age.medico_consulta_id', $operador_id);
        }

        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ag.data', date("Y-m-d", strtotime(str_replace('/', '-', $args['data']))));
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('age.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['exame_id']) && strlen($args['exame_id']) > 0) {
            $this->db->where('ag.guia_id', $args['exame_id']);
        }
        if (isset($args['paciente_id']) && strlen($args['paciente_id']) > 0) {
            $this->db->where('ag.paciente_id', $args['paciente_id']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ag.medico_parecer1', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ag.situacao', $args['situacao']);
        }
        if (isset($args['medicorevisor']) && strlen($args['medicorevisor']) > 0) {
            $this->db->where('ag.medico_parecer2', $args['medicorevisor']);
        }
        if (isset($args['situacaorevisor']) && strlen($args['situacaorevisor']) > 0) {
            $this->db->where('ag.situacao_revisor', $args['situacaorevisor']);
        }
        return $this->db;
    }

    function listarlaudopadrao($procedimento_tuss_id) {
        $this->db->select('aml.ambulatorio_modelo_laudo_id,
                            aml.nome,
                            pt.nome as procedimento,
                            aml.texto');
        $this->db->from('tb_ambulatorio_modelo_laudo aml');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = aml.procedimento_tuss_id');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->where('aml.ativo', 'true');
        $this->db->where('aml.nome', '01PADRAO');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
        $this->db->orderby('aml.nome');
        $return = $this->db->get();
        return $return->result();
    }

    function contadorlistarlaudopadrao($procedimento_tuss_id) {
        $this->db->select('aml.ambulatorio_modelo_laudo_id,
                            aml.nome,
                            pt.nome as procedimento,
                            aml.texto');
        $this->db->from('tb_ambulatorio_modelo_laudo aml');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_tuss_id = aml.procedimento_tuss_id');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->where('aml.ativo', 'true');
        $this->db->where('aml.nome', '01PADRAO');
        $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function listarrevisor($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.situacao,
                            ag.situacao_revisor,
                            o.nome as medico,
                            age.procedimento_tuss_id,
                            op.nome as medicorevisor,
                            age.agenda_exames_nome_id,
                            ag.data_cadastro,
                            p.idade,
                            ag.medico_parecer2,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = age.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->where('ag.empresa_id', $empresa_id);
        $this->db->where("ag.cancelada", 'false');
        $this->db->where("ag.revisor", 'true');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ag.data', $args['data']);
        }
        if (isset($args['prontuario']) && strlen($args['prontuario']) > 0) {
            $this->db->where('p.paciente_id', $args['prontuario']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('age.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('ag.medico_parecer1', $args['medico']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ag.situacao', $args['situacao']);
        }
        if (isset($args['medicorevisor']) && strlen($args['medicorevisor']) > 0) {
            $this->db->where('ag.medico_parecer2', $args['medicorevisor']);
        }
        if (isset($args['situacaorevisor']) && strlen($args['situacaorevisor']) > 0) {
            $this->db->where('ag.situacao_revisor', $args['situacaorevisor']);
        }
        return $this->db;
    }

    function listar2revisor($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.situacao,
                            ag.situacao_revisor,
                            o.nome as medico,
                            age.procedimento_tuss_id,
                            op.nome as medicorevisor,
                            pt.nome as procedimento,
                            p.idade,
                            ag.medico_parecer1,
                            ae.guia_id,
                            ae.agenda_exames_id,
                            ag.data_cadastro,
                            age.agenda_exames_nome_id,
                            ag.medico_parecer2,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = age.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->where('ag.empresa_id', $empresa_id);
        $this->db->where("ag.cancelada", 'false');
        $this->db->where("ag.revisor", 'true');
        $this->db->orderby('ag.situacao');
        $this->db->orderby('ag.data_cadastro');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('p.nome ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('ag.data', $args['data']);
        }
        if (isset($args['prontuario']) && strlen($args['prontuario']) > 0) {
            $this->db->where('p.paciente_id', $args['prontuario']);
        }
        if (isset($args['sala']) && strlen($args['sala']) > 0) {
            $this->db->where('age.agenda_exames_nome_id', $args['sala']);
        }
        if (isset($args['situacao']) && strlen($args['situacao']) > 0) {
            $this->db->where('ag.situacao', $args['situacao']);
        }
        if (isset($args['medicorevisor']) && strlen($args['medicorevisor']) > 0) {
            $this->db->where('ag.medico_parecer2', $args['medicorevisor']);
            $this->db->where("ag.situacao_revisor !=", 'FINALIZADO');
        }
        if (isset($args['situacaorevisor']) && strlen($args['situacaorevisor']) > 0) {
            $this->db->where('ag.situacao_revisor', $args['situacaorevisor']);
        }
        return $this->db;
    }

    function listarprocedimentos($guia_id, $grupo) {
        $this->db->select('ag.procedimento_tuss_id,
                            pt.nome');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ag.guia_id", $guia_id);
        $this->db->where("pt.grupo", $grupo);
        $return = $this->db->get();
        return $return->result();
    }

    function listarlaudoantigo($args = array()) {
        $this->db->select('emissao,
                           nomeexame,
                           nomemedicolaudo,
                           nrmedicolaudo,
                           nomedopaciente');
        $this->db->from('tb_laudoantigo');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nomedopaciente ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('emissao', $args['data']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('nrmedicolaudo', $args['medico']);
        }
        return $this->db;
    }

    function listarlaudoantigo2($args = array()) {
        $this->db->select('id,
                           emissao,
                           nomeexame,
                           nomemedicolaudo,
                           nrmedicolaudo,
                           nomedopaciente');
        $this->db->from('tb_laudoantigo');
        $this->db->orderby('emissao');
        $this->db->orderby('nomedopaciente');
        if (isset($args['nome']) && strlen($args['nome']) > 0) {
            $this->db->where('nomedopaciente ilike', "%" . $args['nome'] . "%");
        }
        if (isset($args['data']) && strlen($args['data']) > 0) {
            $this->db->where('emissao', $args['data']);
        }
        if (isset($args['medico']) && strlen($args['medico']) > 0) {
            $this->db->where('nrmedicolaudo', $args['medico']);
        }
        return $this->db;
    }

    function listarlaudoantigoimpressao($id) {
        $this->db->select('id,
                           emissao,
                           nomeexame,
                           nomemedicolaudo,
                           nrmedicolaudo,
                           nomedopaciente,
                           nomemedicosolic,
                           laudo');
        $this->db->from('tb_laudoantigo');
        $this->db->orderby('emissao');
        $this->db->orderby('nomedopaciente');
        $this->db->where('id', $id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarlaudo($ambulatorio_laudo_id) {

        $this->db->select("ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ae.data,
                            ag.exame_id,
                            ag.situacao,
                            ae.agenda_exames_nome_id,
                            ag.texto,
                            ag.adendo,
                            p.nascimento,
                            p.cpf,
                            ag.situacao_revisor,
                            o.nome as medico,
                            o.conselho,
                            o.carimbo,
                            op.conselho as conselho2,
                            ag.assinatura,
                            ag.rodape,
                            p.rg,
                            ag.guia_id,
                            ag.cabecalho,
                            ag.medico_parecer1,
                            ag.medico_parecer2,
                            ag.cid2,
                            ag.cid as cid1,
                            ag.peso,
                            ag.altura,
                            ag.superficie_corporea,
                            ag.ve_volume_telediastolico,
                            ag.ve_volume_telessistolico,
                            ag.ve_diametro_telediastolico,
                            ag.ve_diametro_telessistolico,
                            ag.ve_indice_do_diametro_diastolico,
                            ag.ve_septo_interventricular,
                            ag.ve_parede_posterior,
                            ag.ve_relacao_septo_parede_posterior,
                            ag.ve_espessura_relativa_paredes,
                            ag.ve_massa_ventricular,
                            ag.ve_indice_massa,
                            ag.ve_relacao_volume_massa,
                            ag.ve_fracao_ejecao,
                            ag.ve_fracao_encurtamento,
                            ag.vd_diametro_telediastolico,
                            ag.vd_area_telediastolica,
                            ag.ve_volume_telessistolico,
                            ag.ae_diametro,                            
                            ag.ao_diametro_raiz,
                            ag.ao_relacao_atrio_esquerdo_aorta,
                            me.nome as solicitante,
                            op.nome as medicorevisor,
                            pt.nome as procedimento,
                            pt.grupo,
                            ae.agenda_exames_id,
                            ag.imagens,
                            es.nome as sala,
                            c.nome as convenio,
                            pc.convenio_id,
                            p.sexo,
                            p.nome as paciente");
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->join('tb_exames e', 'e.exames_id = ag.exame_id ', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador me', 'me.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ag.ambulatorio_laudo_id", $ambulatorio_laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarlaudohistorico($ambulatorio_laudo_id, $paciente_id) {

        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ae.data,
                            ag.exame_id,
                            ag.situacao,
                            ae.agenda_exames_nome_id,
                            ag.texto,
                            p.nascimento,
                            p.cpf,
                            ag.situacao_revisor,
                            o.nome as medico,
                            o.conselho,
                            o.carimbo,
                            op.conselho as conselho2,
                            ag.assinatura,
                            ag.rodape,
                            p.rg,
                            ag.guia_id,
                            ag.cabecalho,
                            ag.medico_parecer1,
                            ag.medico_parecer2,
                            ag.cid2,
                            ag.cid as cid1,
                            ag.peso,
                            ag.altura,
                            ag.superficie_corporea,
                            ag.ve_volume_telediastolico,
                            ag.ve_volume_telessistolico,
                            ag.ve_diametro_telediastolico,
                            ag.ve_diametro_telessistolico,
                            ag.ve_indice_do_diametro_diastolico,
                            ag.ve_septo_interventricular,
                            ag.ve_parede_posterior,
                            ag.ve_relacao_septo_parede_posterior,
                            ag.ve_espessura_relativa_paredes,
                            ag.ve_massa_ventricular,
                            ag.ve_indice_massa,
                            ag.ve_relacao_volume_massa,
                            ag.ve_fracao_ejecao,
                            ag.ve_fracao_encurtamento,
                            ag.vd_diametro_telediastolico,
                            ag.vd_area_telediastolica,
                            ag.ve_volume_telessistolico,
                            ag.ae_diametro,                            
                            ag.ao_diametro_raiz,
                            ag.ao_relacao_atrio_esquerdo_aorta,
                            me.nome as solicitante,
                            op.nome as medicorevisor,
                            pt.nome as procedimento,
                            pt.grupo,
                            ae.agenda_exames_id,
                            ag.imagens,
                            es.nome as sala,
                            c.nome as convenio,
                            pc.convenio_id,
                            p.sexo,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->join('tb_exames e', 'e.exames_id = ag.exame_id ', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador me', 'me.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ag.paciente_id", $paciente_id);
        if ($_GET['medico_id'] != '' && $_GET['medico_id'] != 'TODOS') {
            $this->db->where("ag.medico_parecer1", $_GET['medico_id']);
        }
        $this->db->orderby("ag.ambulatorio_laudo_id desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listarlaudohistoricointernacao($paciente_id) {

        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ae.data,
                            ag.exame_id,
                            ag.situacao,
                            ae.agenda_exames_nome_id,
                            ag.texto,
                            p.nascimento,
                            p.cpf,
                            ag.situacao_revisor,
                            o.nome as medico,
                            o.conselho,
                            o.carimbo,
                            op.conselho as conselho2,
                            ag.assinatura,
                            ag.rodape,
                            p.rg,
                            ag.guia_id,
                            ag.cabecalho,
                            ag.medico_parecer1,
                            ag.medico_parecer2,
                            ag.cid2,
                            ag.cid as cid1,
                            ag.peso,
                            ag.altura,
                            ag.superficie_corporea,
                            ag.ve_volume_telediastolico,
                            ag.ve_volume_telessistolico,
                            ag.ve_diametro_telediastolico,
                            ag.ve_diametro_telessistolico,
                            ag.ve_indice_do_diametro_diastolico,
                            ag.ve_septo_interventricular,
                            ag.ve_parede_posterior,
                            ag.ve_relacao_septo_parede_posterior,
                            ag.ve_espessura_relativa_paredes,
                            ag.ve_massa_ventricular,
                            ag.ve_indice_massa,
                            ag.ve_relacao_volume_massa,
                            ag.ve_fracao_ejecao,
                            ag.ve_fracao_encurtamento,
                            ag.vd_diametro_telediastolico,
                            ag.vd_area_telediastolica,
                            ag.ve_volume_telessistolico,
                            ag.ae_diametro,                            
                            ag.ao_diametro_raiz,
                            ag.ao_relacao_atrio_esquerdo_aorta,
                            me.nome as solicitante,
                            op.nome as medicorevisor,
                            pt.nome as procedimento,
                            pt.grupo,
                            ae.agenda_exames_id,
                            ag.imagens,
                            es.nome as sala,
                            c.nome as convenio,
                            pc.convenio_id,
                            p.sexo,
                            p.nome as paciente');
        $this->db->from('tb_ambulatorio_laudo ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->join('tb_exames e', 'e.exames_id = ag.exame_id ', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_operador me', 'me.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ag.paciente_id", $paciente_id);

        $this->db->orderby("ag.ambulatorio_laudo_id desc");
        $return = $this->db->get();
        return $return->result();
    }

    function listarreceitaimpressao($ambulatorio_laudo_id) {

        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.peso,
                            ag.altura,
                            ag.data,
                            ag.situacao,
                            ae.agenda_exames_nome_id,
                            ar.texto,
                            ar.data_cadastro,
                            p.nascimento,
                            ag.situacao_revisor,
                            o.nome as medico,
                            o.conselho,
                            ag.assinatura,
                            ag.rodape,
                            ag.guia_id,
                            ag.cabecalho,
                            ag.medico_parecer1,
                            ag.medico_parecer2,
                            me.nome as solicitante,
                            op.nome as medicorevisor,
                            pt.nome as procedimento,
                            pt.grupo,
                            ae.agenda_exames_id,
                            ag.imagens,
                            c.nome as convenio,
                            pc.convenio_id,
                            p.nome as paciente,
                            p.cpf,
                            p.nascimento,
                            p.sexo,
                            ar.assinatura,
                            ar.carimbo,
                            o.carimbo as medico_carimbo');
        $this->db->from('tb_ambulatorio_receituario ar');
        $this->db->join('tb_ambulatorio_laudo ag', 'ag.ambulatorio_laudo_id = ar.laudo_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->join('tb_exames e', 'e.exames_id = ag.exame_id ', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_operador me', 'me.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ar.ambulatorio_receituario_id", $ambulatorio_laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarsolicitarexameimpressao($ambulatorio_laudo_id) {
        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.situacao,
                            ae.agenda_exames_nome_id,
                            ar.texto,
                            p.nascimento,
                            ag.situacao_revisor,
                            o.nome as medico,
                            o.conselho,
                            ag.assinatura,
                            ag.rodape,
                            ag.guia_id,
                            ag.cabecalho,
                            ag.medico_parecer1,
                            ag.medico_parecer2,
                            me.nome as solicitante,
                            op.nome as medicorevisor,
                            pt.nome as procedimento,
                            pt.grupo,
                            ae.agenda_exames_id,
                            ag.imagens,
                            c.nome as convenio,
                            pc.convenio_id,
                            p.nome as paciente,
                            ar.assinatura,
                            ar.carimbo,
                            o.carimbo as medico_carimbo');
        $this->db->from('tb_ambulatorio_exame ar');
        $this->db->join('tb_ambulatorio_laudo ag', 'ag.ambulatorio_laudo_id = ar.laudo_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->join('tb_exames e', 'e.exames_id = ag.exame_id ', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_operador me', 'me.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ar.ambulatorio_exame_id", $ambulatorio_laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaratestadoimpressao($ambulatorio_laudo_id) {

        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.peso,
                            ag.altura,
                            ag.situacao,
                            ae.agenda_exames_nome_id,
                            ar.texto,
                            ar.data,
                            ar.imprimir_cid,
                            ar.cid1,
                            ar.cid2,
                            p.nascimento,
                            ag.situacao_revisor,
                            o.nome as medico,
                            o.conselho,
                            ag.assinatura,
                            ag.rodape,
                            ag.guia_id,
                            ag.cabecalho,
                            ag.medico_parecer1,
                            ag.medico_parecer2,
                            me.nome as solicitante,
                            op.nome as medicorevisor,
                            pt.nome as procedimento,
                            pt.grupo,
                            ae.agenda_exames_id,
                            ag.imagens,
                            c.nome as convenio,
                            pc.convenio_id,
                            p.nome as paciente,
                            p.nascimento,
                            p.cpf,
                            p.sexo,
                            ar.assinatura,
                            ar.carimbo,
                            o.carimbo as medico_carimbo');
        $this->db->from('tb_ambulatorio_atestado ar');
        $this->db->join('tb_ambulatorio_laudo ag', 'ag.ambulatorio_laudo_id = ar.laudo_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->join('tb_exames e', 'e.exames_id = ag.exame_id ', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_operador me', 'me.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ar.ambulatorio_atestado_id", $ambulatorio_laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarformimpressao($ambulatorio_laudo_id) {

        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.peso,
                            ag.altura,
                            ag.situacao,
                            ae.agenda_exames_nome_id,
                            ar.texto,
                            ar.data,
                            ar.imprimir_cid,
                            ar.cid1,
                            ar.cid2,
                            p.nascimento,
                            ag.situacao_revisor,
                            o.nome as medico,
                            o.conselho,
                            ag.assinatura,
                            ag.rodape,
                            ag.guia_id,
                            ag.cabecalho,
                            ag.medico_parecer1,
                            ag.medico_parecer2,
                            me.nome as solicitante,
                            op.nome as medicorevisor,
                            pt.nome as procedimento,
                            pt.grupo,
                            ae.agenda_exames_id,
                            ag.imagens,
                            c.nome as convenio,
                            pc.convenio_id,
                            p.nome as paciente,
                            p.nascimento,
                            p.cpf,
                            p.sexo,
                            ar.assinatura,
                            ar.carimbo,
                            o.carimbo as medico_carimbo');
        $this->db->from('tb_ambulatorio_atestado ar');
        $this->db->join('tb_ambulatorio_laudo ag', 'ag.ambulatorio_laudo_id = ar.laudo_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->join('tb_exames e', 'e.exames_id = ag.exame_id ', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_operador me', 'me.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ar.ambulatorio_atestado_id", $ambulatorio_laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listarcid($param) {
        $this->db->select('*');
        $this->db->from('tb_cid');
        $this->db->where("co_cid", $param);
        $return = $this->db->get();
        return $return->result();
    }

    function listarreceitaespecialimpressao($ambulatorio_laudo_id) {

        $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.exame_id,
                            ag.situacao,
                            ae.agenda_exames_nome_id,
                            ar.texto,
                            p.bairro,
                            p.nascimento,
                            p.nome as paciente,
                            p.logradouro,
                            p.numero,
                            mp.nome as cidade,
                            mp.estado as estado,
                            p.rg,
                            p.uf_rg,
                            ag.situacao_revisor,
                            o.nome as medico,
                            o.conselho,
                            ag.assinatura,
                            ag.rodape,
                            ag.guia_id,
                            ag.cabecalho,
                            ag.medico_parecer1,
                            pt.nome as procedimento,
                            pt.grupo,
                            ae.agenda_exames_id,
                            ag.imagens,
                            ar.data_cadastro,
                            m.nome as cidaempresa,
                            m.estado as estadoempresa,
                            ep.bairro as bairroemp,
                            ep.logradouro as endempresa,
                            ep.numero as numeroempresa,
                            ep.telefone as telempresa,
                            ep.celular as celularempresa,
                            tl.descricao as tipologradouro,
                            c.nome as convenio,
                            pc.convenio_id,
                            ar.assinatura,
                            ar.carimbo,
                            o.carimbo as medico_carimbo');
        $this->db->from('tb_ambulatorio_receituario_especial ar');
        $this->db->join('tb_ambulatorio_laudo ag', 'ag.ambulatorio_laudo_id = ar.laudo_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ar.medico_parecer1', 'left');
        $this->db->join('tb_tipo_logradouro tl', 'tl.tipo_logradouro_id = o.tipo_logradouro', 'left');
        $this->db->join('tb_exames e', 'e.exames_id = ag.exame_id ', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_empresa ep', 'ep.empresa_id = ae.empresa_id', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = ep.municipio_id', 'left');
        $this->db->join('tb_municipio mp', 'mp.municipio_id = p.municipio_id', 'left');
        $this->db->where("ar.ambulatorio_receituario_especial_id", $ambulatorio_laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($ambulatorio_laudo_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ativo', 'f');
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
        $this->db->update('tb_ambulatorio_laudo');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function gravar($paciente_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            else
                $ambulatorio_laudo_id = $this->db->insert_id();


            return $ambulatorio_laudo_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarencaminhamentoatendimento() {
        try {
            /* inicia o mapeamento no banco */
//            $horario = date("Y-m-d H:i:s");
//            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('encaminhado', 't');
            $this->db->set('medico_encaminhamento_id', $_POST['medico_id']);
            $this->db->where('ambulatorio_laudo_id', $_POST['ambulatorio_laudo_id']);
            $this->db->update('tb_ambulatorio_laudo');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarhistorico($paciente_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('laudo', $_POST['laudo']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_laudoantigo');
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarautocompletelaudos($parametro = null) {
        $this->db->select('texto');
        $this->db->from('tb_ambulatorio_laudo');
        $this->db->where('ambulatorio_laudo_id', $parametro);
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleterepetirreceituario($ambulatorio_laudo_id) {
        $this->db->select(' ag.ambulatorio_receituario_id ,
                            ag.data_cadastro,
                            ag.texto,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_receituario ag');
        $this->db->where('ag.ambulatorio_receituario_id', $ambulatorio_laudo_id);
        $this->db->where('ag.tipo', 'NORMAL');
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteeditarreceituario($ambulatorio_laudo_id) {
        $this->db->select(' ag.ambulatorio_receituario_id ,
                            ag.texto,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_receituario ag');
        $this->db->where('ag.ambulatorio_receituario_id', $ambulatorio_laudo_id);
        $this->db->where('ag.tipo', 'NORMAL');
        $return = $this->db->get();
        return $return->result();
    }

    function listarlaudos($parametro, $ambulatorio_laudo_id) {

        $this->db->select('al.data_cadastro,
                            pt.nome as procedimento,
                            p.nome as paciente,
                            o.nome as medico,
                            pi.nome as indicacao,
                            al.peso,
                            al.altura,
                            al.exame_id,
                            al.ambulatorio_laudo_id');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->join('tb_paciente p', 'p.paciente_id = al.paciente_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_exames e', 'e.exames_id = al.exame_id ', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('al.paciente_id', $parametro);
        $this->db->where('al.ambulatorio_laudo_id !=', $ambulatorio_laudo_id);
        $this->db->orderby('al.data_cadastro desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarlaudospesoaltura($parametro) {

        $this->db->select('al.data_cadastro,
                            pt.nome as procedimento,
                            p.nome as paciente,
                            o.nome as medico,
                            pi.nome as indicacao,
                            ag.peso,
                            ag.altura,
                            al.exame_id,
                            al.ambulatorio_laudo_id');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->join('tb_paciente p', 'p.paciente_id = al.paciente_id', 'left');
        $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_exames e', 'e.exames_id = al.exame_id ', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_guia ag', 'ag.ambulatorio_guia_id = ae.guia_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('al.paciente_id', $parametro);
        $this->db->where('ag.peso > 0');
        $this->db->where('ag.altura > 0');
//        $this->db->where('al.ambulatorio_laudo_id !=', $ambulatorio_laudo_id);
        $this->db->orderby('al.data_cadastro desc');
        $return = $this->db->get();
        return $return->result();
    }

    function listarlaudosintegracao($agenda_exames_id) {

        $this->db->select('exame_id');
        $this->db->from('tb_integracao_laudo');
        $this->db->where('exame_id', $agenda_exames_id);
        $this->db->where('laudo_status', 'PUBLICADO');
        $return = $this->db->get();
        return $return->result();
    }

    function atualizacaolaudosintegracao($agenda_exames_id) {


        $this->db->select('il.integracao_laudo_id,
                            il.exame_id,
                            il.laudo_texto,
                            il.laudo_data_hora,
                            al.ambulatorio_laudo_id,
                            il.laudo_status,
                            al.ambulatorio_laudo_id,
                            o.operador_id as medico,
                            op.operador_id as revisor');
        $this->db->from('tb_integracao_laudo il');
        $this->db->join('tb_operador o', 'o.conselho = il.laudo_conselho_medico', 'left');
        $this->db->join('tb_operador op', 'op.conselho = il.laudo_conselho_medico_revisor', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id = il.exame_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->where('il.exame_id', $agenda_exames_id);
        $this->db->where('il.laudo_status', 'PUBLICADO');
        $this->db->where('o.ativo', 't');
        $this->db->where('op.ativo', 't');
        $this->db->orderby('il.integracao_laudo_id');
        $query = $this->db->get();
        $return = $query->result();

        foreach ($return as $value) {
            $laudo_texto = $value->laudo_texto;
            $laudo_data_hora = $value->laudo_data_hora;
            $ambulatorio_laudo_id = $value->ambulatorio_laudo_id;
            $medico = $value->medico;
            $revisor = $value->revisor;
            $this->db->set('texto', $laudo_texto);
            $this->db->set('situacao', 'FINALIZADO');
            $this->db->set('medico_parecer1', $medico);
            $this->db->set('medico_parecer2', $revisor);
            $this->db->set('data_atualizacao', $laudo_data_hora);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
        }

        $this->db->set('medico_consulta_id', $medico);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');

        $this->db->set('laudo_status', 'LIDO');
        $this->db->where('exame_id', $agenda_exames_id);
        $this->db->update('tb_integracao_laudo');
    }

    function listarlaudoscontador($parametro, $ambulatorio_laudo_id) {

        $this->db->select('al.data_cadastro,
                            pt.nome,
                            p.nome as paciente,
                            o.nome as medico,
                            al.exame_id,
                            al.ambulatorio_laudo_id');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->join('tb_paciente p', 'p.paciente_id = al.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = al.medico_parecer1', 'left');
        $this->db->join('tb_exames e', 'e.exames_id = al.exame_id ', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('al.paciente_id', $parametro);
        $this->db->where('al.ambulatorio_laudo_id !=', $ambulatorio_laudo_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function gravarlaudo($ambulatorio_laudo_id, $exame_id, $sala_id, $procedimento_tuss_id) {
        try {
            /* inicia o mapeamento no banco */
            $this->db->set('ativo', 't');
            $this->db->where('exame_sala_id', $sala_id);
            $this->db->update('tb_exame_sala');

            if (isset($_POST['indicado'])) {
                $this->db->set('indicado', 't');
            } else {
                $this->db->set('indicado', 'f');
            }
            $this->db->set('situacao', 'FINALIZADO');
            $this->db->where('exames_id', $exame_id);
            $this->db->update('tb_exames');

            $this->db->select('agenda_exames_id');
            $this->db->from('tb_exames');
            $this->db->where("exames_id", $exame_id);
            $query = $this->db->get();
            $return = $query->result();


            $this->db->select('mc.valor as perc_medico, mc.percentual');
            $this->db->from('tb_procedimento_percentual_medico_convenio mc');
            $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
            $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
            $this->db->where('mc.medico', $_POST['medico']);
            $this->db->where('mc.ativo', 'true');
            $this->db->where('mc.revisor', 'false');
            $percentual = $this->db->get()->result();

            if (count($percentual) == 0) {
                $this->db->select('pt.perc_medico, pt.percentual');
                $this->db->from('tb_procedimento_convenio pc');
                $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
//                        $this->db->where('pc.ativo', 'true');
//                        $this->db->where('pt.ativo', 'true');
                $percentual = $this->db->get()->result();
            }
            if ($_POST['medicorevisor'] != '') {
                $this->db->select('mc.valor as perc_medico, mc.percentual');
                $this->db->from('tb_procedimento_percentual_medico_convenio mc');
                $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
                $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
                $this->db->where('mc.medico', $_POST['medicorevisor']);
                $this->db->where('mc.ativo', 'true');
                $this->db->where('mc.revisor', 'true');
                $percentualrevisor = $this->db->get()->result();
                if (count($percentualrevisor) == 0) {
                    $this->db->select('pt.valor_revisor as perc_medico, pt.percentual_revisor as percentual');
                    $this->db->from('tb_procedimento_convenio pc');
                    $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                    $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
//                        $this->db->where('pc.ativo', 'true');
//                        $this->db->where('pt.ativo', 'true');
                    $percentualrevisor = $this->db->get()->result();
                }
            }

            if (isset($_POST['rev'])) {
                switch ($_POST['tempoRevisao']) {
                    case '1a':
                        $dias = '+1 year';
                        break;
                    case '6m':
                        $dias = '+6 month';
                        break;
                    case '3m':
                        $dias = '+3 month';
                        break;
                    case '1m':
                        $dias = '+1 month';
                        break;
                    default:
                        $dias = '';
                }
                if ($dias != '') {
                    $diaRevisao = date('Y-m-d', strtotime($dias));
                    $this->db->set('data_revisao', $diaRevisao);
                }
            }

            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
            if ($_POST['medicorevisor'] != '') {

                $this->db->set('valor_revisor', $percentualrevisor[0]->perc_medico);
                $this->db->set('percentual_revisor', $percentualrevisor[0]->percentual);
            }
            $this->db->set('medico_agenda', $_POST['medico']);
            $this->db->set('medico_consulta_id', $_POST['medico']);
            $this->db->where('agenda_exames_id', $return[0]->agenda_exames_id);
            $this->db->update('tb_agenda_exames');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if (isset($_POST['revisor'])) {
                $this->db->set('revisor', 't');
                $this->db->set('situacao_revisor', 'AGUARDANDO');
            } else {
                $this->db->set('revisor', 'f');
            }
            $this->db->set('texto_laudo', $_POST['laudo']);

            $this->db->set('texto', $_POST['laudo']);
            if ($_POST['adendo'] != '') {
                $post_adendo = str_replace('<!DOCTYPE html>', '', $_POST['adendo']);
                $post_adendo = str_replace('<html>', '', $post_adendo);
                $post_adendo = str_replace('<head>', '', $post_adendo);
                $post_adendo = str_replace('</head>', '', $post_adendo);
                $post_adendo = str_replace('<body>', '', $post_adendo);
                $adendo_coluna = "<p><strong>Adendo de: " . date("d/m/Y H:i:s") . "<br></strong></p>" . $post_adendo;
                $adendo = str_replace('</body>', '', $_POST['laudo']);
                $adendo = str_replace('</html>', '', $adendo);

                $adendo = $adendo . $adendo_coluna . "</body></html>";
//                $this->db->set('adendo', $adendo_coluna);
                $this->db->set("texto", $adendo);
            }
//            if ($_POST['adendo'] != '') {
//                $post_adendo = str_replace('<!DOCTYPE html>', '', $_POST['adendo']) ;
//                $post_adendo = str_replace('<html>', '', $post_adendo) ;
//                $post_adendo = str_replace('<head>', '', $post_adendo) ;
//                $post_adendo = str_replace('</head>', '', $post_adendo) ;
//                $post_adendo = str_replace('<body>', '', $post_adendo) ;
//                $adendo_coluna = "<p><strong>Adendo de: " . date("d/m/Y H:i:s") . "<br></strong></p>" . $post_adendo;
//                $adendo = str_replace('</body>', '', $_POST['laudo']);
//                $adendo = str_replace('</html>', '', $adendo);
//                
//                $adendo = $adendo . $adendo_coluna . "</body></html>";
////                $this->db->set('adendo', $adendo_coluna);
//                $this->db->set("texto", $adendo);
//            }
//            var_dump($adendo); die;


            if ($_POST['medico'] != '') {
                $this->db->set('medico_parecer1', $_POST['medico']);
            }
            if ($_POST['medicorevisor'] != '') {
                $this->db->set('medico_parecer2', $_POST['medicorevisor']);
            } else {
                $this->db->set('medico_parecer2', null);
            }
            if (isset($_POST['assinatura'])) {
                $this->db->set('assinatura', 't');
            } else {
                $this->db->set('assinatura', 'f');
            }

            $this->db->set('cabecalho', $_POST['cabecalho']);
            if (isset($_POST['imagem'])) {
                $this->db->set('imagens', $_POST['imagem']);
            }

            $this->db->set('situacao', 'FINALIZADO');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarlaudolaboratorial($ambulatorio_laudo_id, $exame_id) {
        try {
            /* inicia o mapeamento no banco */
            if (isset($_POST['indicado'])) {
                $this->db->set('indicado', 't');
            } else {
                $this->db->set('indicado', 'f');
            }
            $this->db->where('exames_id', $exame_id);
            $this->db->update('tb_exames');



            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if (isset($_POST['revisor'])) {
                $this->db->set('revisor', 't');
                $this->db->set('situacao_revisor', 'AGUARDANDO');
            } else {
                $this->db->set('revisor', 'f');
            }
            $this->db->set('texto_laudo', $_POST['laudo']);
            $this->db->set('texto', $_POST['laudo']);
            if ($_POST['medico'] != '') {
                $this->db->set('medico_parecer1', $_POST['medico']);
            }
            if ($_POST['medicorevisor'] != '') {
                $this->db->set('medico_parecer2', $_POST['medicorevisor']);
            } else {
                $this->db->set('medico_parecer2', null);
            }
            if (isset($_POST['assinatura'])) {
                $this->db->set('assinatura', 't');
            } else {
                $this->db->set('assinatura', 'f');
            }

            $this->db->set('cabecalho', $_POST['cabecalho']);
            if (isset($_POST['imagem'])) {
                $this->db->set('imagens', $_POST['imagem']);
            }
            $this->db->set('situacao', 'FINALIZADO');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarlaudoeco($ambulatorio_laudo_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if (isset($_POST['revisor'])) {
                $this->db->set('revisor', 't');
                $this->db->set('situacao_revisor', 'AGUARDANDO');
            } else {
                $this->db->set('revisor', 'f');
            }
            $this->db->set('texto_laudo', $_POST['laudo']);
            $this->db->set('texto', $_POST['laudo']);
            if ($_POST['medico'] != '') {
                $this->db->set('medico_parecer1', $_POST['medico']);
            }
            if ($_POST['Peso'] != '') {
                $this->db->set('peso', str_replace(",", ".", $_POST['peso']));
            }
            if ($_POST['Altura'] != '') {
                $this->db->set('altura', $_POST['Altura']);
            }
            if ($_POST['Superf'] != '0.00') {
                $this->db->set('superficie_corporea', $_POST['Superf']);
            }
            if ($_POST['Volume_telediastolico'] != '0.00') {
                $this->db->set('ve_volume_telediastolico', $_POST['Volume_telediastolico']);
            }
            if ($_POST['Volume_telessistolico'] != '0.00') {
                $this->db->set('ve_volume_telessistolico', $_POST['Volume_telessistolico']);
            }
            if ($_POST['Diametro_telediastolico'] != '') {
                $this->db->set('ve_diametro_telediastolico', $_POST['Diametro_telediastolico']);
            }
            if ($_POST['Diametro_telessistolico'] != '') {
                $this->db->set('ve_diametro_telessistolico', $_POST['Diametro_telessistolico']);
            }
            if ($_POST['indice_diametro_diastolico'] != 'NaN') {
                $this->db->set('ve_indice_do_diametro_diastolico', $_POST['indice_diametro_diastolico']);
            }
            if ($_POST['Septo_interventricular'] != '') {
                $this->db->set('ve_septo_interventricular', $_POST['Septo_interventricular']);
            }
            if ($_POST['Parede_posterior'] != '') {
                $this->db->set('ve_parede_posterior', $_POST['Parede_posterior']);
            }
            if ($_POST['Relacao_septo_parede'] != 'NaN') {
                $this->db->set('ve_relacao_septo_parede_posterior', $_POST['Relacao_septo_parede']);
            }
            if ($_POST['Espessura_relativa'] != 'NaN') {
                $this->db->set('ve_espessura_relativa_paredes', $_POST['Espessura_relativa']);
            }
            if ($_POST['Massa_ventricular'] != '0.60') {
                $this->db->set('ve_massa_ventricular', $_POST['Massa_ventricular']);
            }
            if ($_POST['indice_massa'] != 'Infinity') {
                $this->db->set('ve_indice_massa', $_POST['indice_massa']);
            }
            if ($_POST['Relacao_volume_massa'] != '0.00') {
                $this->db->set('ve_relacao_volume_massa', $_POST['Relacao_volume_massa']);
            }
            if ($_POST['Fracao_ejecao'] != 'NaN') {
                $this->db->set('ve_fracao_ejecao', $_POST['Fracao_ejecao']);
            }
            if ($_POST['Fracao_encurtamento'] != 'NaN') {
                $this->db->set('ve_fracao_encurtamento', $_POST['Fracao_encurtamento']);
            }
            if ($_POST['Diametro_telediastolico'] != '') {
                $this->db->set('vd_diametro_telediastolico', $_POST['Diametro_telediastolico']);
            }
            if ($_POST['area_telediastolica'] != '') {
                $this->db->set('vd_area_telediastolica', $_POST['area_telediastolica']);
            }
            if ($_POST['Diametro'] != '') {
                $this->db->set('ae_diametro', $_POST['Diametro']);
            }
            if ($_POST['indice_diametro'] != '') {
                $this->db->set('ae_indice_diametro', $_POST['indice_diametro']);
            }
            if ($_POST['Diametro_raiz'] != '') {
                $this->db->set('ao_diametro_raiz', $_POST['Diametro_raiz']);
            }
            if ($_POST['Relacao_atrio_esquerdo'] != 'NaN') {
                $this->db->set('ao_relacao_atrio_esquerdo_aorta', $_POST['Relacao_atrio_esquerdo']);
            }
            if ($_POST['medicorevisor'] != '') {
                $this->db->set('medico_parecer2', $_POST['medicorevisor']);
            } else {
                $this->db->set('medico_parecer2', null);
            }
            if (isset($_POST['assinatura'])) {
                $this->db->set('assinatura', 't');
            } else {
                $this->db->set('assinatura', 'f');
            }
            if (isset($_POST['rodape'])) {
                $this->db->set('rodape', 't');
            } else {
                $this->db->set('rodape', 'f');
            }
            $this->db->set('cabecalho', $_POST['cabecalho']);
            if (isset($_POST['imagem'])) {
                $this->db->set('imagens', $_POST['imagem']);
            }
            $this->db->set('situacao', 'FINALIZADO');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaroit() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('medico_parecer', $_POST['medico_parecer']);
            if ($_POST['data'] != "") {
                $this->db->set('data', $_POST['data']);
            }
            $this->db->set('qualidade_tecnica', $_POST['qualidade_tecnica']);
            $this->db->set('radiografia_normal', $_POST['radiografia_normal']);
            $this->db->set('comentario_1a', $_POST['comentario_1a']);
            $this->db->set('anormalidade_parenquima', $_POST['anormalidade_parenquima']);
            $this->db->set('forma_primaria', $_POST['forma_primaria']);
            $this->db->set('forma_secundaria', $_POST['forma_secundaria']);
            $this->db->set('zona_d', $_POST['zona_d']);
            $this->db->set('zona_e', $_POST['zona_e']);
            $this->db->set('profusao', $_POST['profusao']);
            $this->db->set('grandes_opacidades', $_POST['grandes_opacidades']);
            $this->db->set('anormalidade_pleural', $_POST['anormalidade_pleural']);
            $this->db->set('placa_pleuras', $_POST['placa_pleuras']);
            $this->db->set('local_paredeperfil_3b', $_POST['local_paredeperfil_3b']);
            $this->db->set('local_frontal_3b', $_POST['local_frontal_3b']);
            $this->db->set('local_diafragma_3b', $_POST['local_diafragma_3b']);
            $this->db->set('local_outroslocais_3b', $_POST['local_outroslocais_3b']);
            $this->db->set('calcificacao_paredeperfil_3b', $_POST['calcificacao_paredeperfil_3b']);
            $this->db->set('calcificacao_frontal_3b', $_POST['calcificacao_frontal_3b']);
            $this->db->set('calcificacao_diafragma_3b', $_POST['calcificacao_diafragma_3b']);
            $this->db->set('calcificacao_outroslocais_3b', $_POST['calcificacao_outroslocais_3b']);
            $this->db->set('extensao_parede_d_3b', $_POST['extensao_parede_d_3b']);
            $this->db->set('extensao_parede_e_3b', $_POST['extensao_parede_e_3b']);
            $this->db->set('largura_d_3b', $_POST['largura_d_3b']);
            $this->db->set('largura_e_3b', $_POST['largura_e_3b']);
            $this->db->set('obliteracao', $_POST['obliteracao']);
            $this->db->set('espessamento_pleural_difuso', $_POST['espessamento_pleural_difuso']);
            $this->db->set('local_parede_perfil_3d', $_POST['local_parede_perfil_3d']);
            $this->db->set('local_parede_frontal_3d', $_POST['local_parede_frontal_3d']);
            $this->db->set('calcificacao_parede_perfil_3d', $_POST['calcificacao_parede_perfil_3d']);
            $this->db->set('calcificacao_parede_frontal_3d', $_POST['calcificacao_parede_frontal_3d']);
            $this->db->set('extensao_parede_d_3b', $_POST['extensao_parede_d_3b']);
            $this->db->set('extensao_parede_e_3b', $_POST['extensao_parede_e_3b']);
            $this->db->set('largura_d_3b', $_POST['largura_e_3b']);
            $this->db->set('anormalidade_parenquima', $_POST['anormalidade_parenquima']);
            $this->db->set('simbolos', $_POST['simbolos']);
            $this->db->set('comentario_4c', $_POST['comentario_4c']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_laudooit_id', $_POST['ambulatorio_laudooit_id']);
            $this->db->update('tb_ambulatorio_laudooit');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
//            $this->db->set('situacao', 'FINALIZADO');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarlaudodigitando($ambulatorio_laudo_id, $exame_id, $procedimento_tuss_id) {
        try {
            /* inicia o mapeamento no banco */

            if (isset($_POST['indicado'])) {
                $this->db->set('indicado', 't');
            } else {
                $this->db->set('indicado', 'f');
            }
            $this->db->where('exames_id', $exame_id);
            $this->db->update('tb_exames');

            $this->db->select('agenda_exames_id');
            $this->db->from('tb_exames');
            $this->db->where("exames_id", $exame_id);
            $query = $this->db->get();
            $return = $query->result();


            $this->db->select('mc.valor as perc_medico, mc.percentual');
            $this->db->from('tb_procedimento_percentual_medico_convenio mc');
            $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
            $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
            $this->db->where('mc.medico', $_POST['medico']);
            $this->db->where('mc.ativo', 'true');
            $percentual = $this->db->get()->result();

            if (count($percentual) == 0) {
                $this->db->select('pt.perc_medico, pt.percentual');
                $this->db->from('tb_procedimento_convenio pc');
                $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
//                        $this->db->where('pc.ativo', 'true');
//                        $this->db->where('pt.ativo', 'true');
                $percentual = $this->db->get()->result();
            }

//            var_dump($percentual); die;
            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
            $this->db->set('medico_agenda', $_POST['medico']);
            $this->db->where('agenda_exames_id', $return[0]->agenda_exames_id);
            $this->db->update('tb_agenda_exames');

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if (isset($_POST['revisor'])) {
                $this->db->set('revisor', 't');
                $this->db->set('situacao_revisor', 'AGUARDANDO');
            } else {
                $this->db->set('revisor', 'f');
            }
            $this->db->set('texto_laudo', $_POST['laudo']);
            $this->db->set('texto', $_POST['laudo']);
            if ($_POST['medico'] != '') {
                $this->db->set('medico_parecer1', $_POST['medico']);
            }
            if ($_POST['medicorevisor'] != '') {
                $this->db->set('medico_parecer2', $_POST['medicorevisor']);
            } else {
                $this->db->set('medico_parecer2', null);
            }
            if (isset($_POST['assinatura'])) {
                $this->db->set('assinatura', 't');
            } else {
                $this->db->set('assinatura', 'f');
            }

            $this->db->set('cabecalho', $_POST['cabecalho']);
            if (isset($_POST['imagem'])) {
                $this->db->set('imagens', $_POST['imagem']);
            }
            if ($_POST['situacao'] != 'FINALIZADO') {
                $this->db->set('situacao', $_POST['situacao']);
            } else {
                $this->db->set('situacao', 'DIGITANDO');
            }
//            var_dump($_POST['situacao']); die;
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarlaudodigitandolaboratorial($ambulatorio_laudo_id, $exame_id) {
        try {
            /* inicia o mapeamento no banco */

            if (isset($_POST['indicado'])) {
                $this->db->set('indicado', 't');
            } else {
                $this->db->set('indicado', 'f');
            }
            $this->db->where('exames_id', $exame_id);
            $this->db->update('tb_exames');






            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if (isset($_POST['revisor'])) {
                $this->db->set('revisor', 't');
                $this->db->set('situacao_revisor', 'AGUARDANDO');
            } else {
                $this->db->set('revisor', 'f');
            }
            $this->db->set('texto_laudo', $_POST['laudo']);
            $this->db->set('texto', $_POST['laudo']);
            if ($_POST['medico'] != '') {
                $this->db->set('medico_parecer1', $_POST['medico']);
            }
            if ($_POST['medicorevisor'] != '') {
                $this->db->set('medico_parecer2', $_POST['medicorevisor']);
            } else {
                $this->db->set('medico_parecer2', null);
            }
            if (isset($_POST['assinatura'])) {
                $this->db->set('assinatura', 't');
            } else {
                $this->db->set('assinatura', 'f');
            }

            $this->db->set('cabecalho', $_POST['cabecalho']);
            if (isset($_POST['imagem'])) {
                $this->db->set('imagens', $_POST['imagem']);
            }
            $this->db->set('situacao', 'DIGITANDO');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarlaudodigitandoeco($ambulatorio_laudo_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if (isset($_POST['revisor'])) {
                $this->db->set('revisor', 't');
                $this->db->set('situacao_revisor', 'AGUARDANDO');
            } else {
                $this->db->set('revisor', 'f');
            }
            $this->db->set('texto_laudo', $_POST['laudo']);
            $this->db->set('texto', $_POST['laudo']);
            if ($_POST['Peso'] != '') {
                $this->db->set('peso', str_replace(",", ".", $_POST['peso']));
            }
            if ($_POST['Altura'] != '') {
                $this->db->set('altura', $_POST['Altura']);
            }
            if ($_POST['Superf'] != '0.00') {
                $this->db->set('superficie_corporea', $_POST['Superf']);
            }
            if ($_POST['Volume_telediastolico'] != '0.00') {
                $this->db->set('ve_volume_telediastolico', $_POST['Volume_telediastolico']);
            }
            if ($_POST['Volume_telessistolico'] != '0.00') {
                $this->db->set('ve_volume_telessistolico', $_POST['Volume_telessistolico']);
            }
            if ($_POST['Diametro_telediastolico'] != '') {
                $this->db->set('ve_diametro_telediastolico', $_POST['Diametro_telediastolico']);
            }
            if ($_POST['Diametro_telessistolico'] != '') {
                $this->db->set('ve_diametro_telessistolico', $_POST['Diametro_telessistolico']);
            }
            if ($_POST['indice_diametro_diastolico'] != 'NaN') {
                $this->db->set('ve_indice_do_diametro_diastolico', $_POST['indice_diametro_diastolico']);
            }
            if ($_POST['Septo_interventricular'] != '') {
                $this->db->set('ve_septo_interventricular', $_POST['Septo_interventricular']);
            }
            if ($_POST['Parede_posterior'] != '') {
                $this->db->set('ve_parede_posterior', $_POST['Parede_posterior']);
            }
            if ($_POST['Relacao_septo_parede'] != 'NaN') {
                $this->db->set('ve_relacao_septo_parede_posterior', $_POST['Relacao_septo_parede']);
            }
            if ($_POST['Espessura_relativa'] != 'NaN') {
                $this->db->set('ve_espessura_relativa_paredes', $_POST['Espessura_relativa']);
            }
            if ($_POST['Massa_ventricular'] != '0.60') {
                $this->db->set('ve_massa_ventricular', $_POST['Massa_ventricular']);
            }
            if ($_POST['indice_massa'] != 'Infinity') {
                $this->db->set('ve_indice_massa', $_POST['indice_massa']);
            }
            if ($_POST['Relacao_volume_massa'] != '0.00') {
                $this->db->set('ve_relacao_volume_massa', $_POST['Relacao_volume_massa']);
            }
            if ($_POST['Fracao_ejecao'] != 'NaN') {
                $this->db->set('ve_fracao_ejecao', $_POST['Fracao_ejecao']);
            }
            if ($_POST['Fracao_encurtamento'] != 'NaN') {
                $this->db->set('ve_fracao_encurtamento', $_POST['Fracao_encurtamento']);
            }
            if ($_POST['Diametro_telediastolico'] != '') {
                $this->db->set('vd_diametro_telediastolico', $_POST['Diametro_telediastolico']);
            }
            if ($_POST['area_telediastolica'] != '') {
                $this->db->set('vd_area_telediastolica', $_POST['area_telediastolica']);
            }
            if ($_POST['Diametro'] != '') {
                $this->db->set('ae_diametro', $_POST['Diametro']);
            }
            if ($_POST['indice_diametro'] != '') {
                $this->db->set('ae_indice_diametro', $_POST['indice_diametro']);
            }
            if ($_POST['Diametro_raiz'] != '') {
                $this->db->set('ao_diametro_raiz', $_POST['Diametro_raiz']);
            }
            if ($_POST['Relacao_atrio_esquerdo'] != 'NaN') {
                $this->db->set('ao_relacao_atrio_esquerdo_aorta', $_POST['Relacao_atrio_esquerdo']);
            }
            if ($_POST['medico'] != '') {
                $this->db->set('medico_parecer1', $_POST['medico']);
            }
            if ($_POST['medicorevisor'] != '') {
                $this->db->set('medico_parecer2', $_POST['medicorevisor']);
            } else {
                $this->db->set('medico_parecer2', null);
            }
            if (isset($_POST['assinatura'])) {
                $this->db->set('assinatura', 't');
            } else {
                $this->db->set('assinatura', 'f');
            }
            if (isset($_POST['rodape'])) {
                $this->db->set('rodape', 't');
            } else {
                $this->db->set('rodape', 'f');
            }
            $this->db->set('cabecalho', $_POST['cabecalho']);
            if (isset($_POST['imagem'])) {
                $this->db->set('imagens', $_POST['imagem']);
            }
            $this->db->set('situacao', 'DIGITANDO');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listardadoservicoemail($ambulatorio_laudo_id, $exame_id) {
        /* inicia o mapeamento no banco */
        $horario = date("Y-m-d H:i:s");
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('p.cns');
        $this->db->from('tb_exames e');
        $this->db->join('tb_paciente p', 'p.paciente_id = e.paciente_id');
        $this->db->where("exames_id", $exame_id);
        $query = $this->db->get();
        $return1 = $query->result();

        $this->db->select('email, email_mensagem_agradecimento as msg, razao_social');
        $this->db->from('tb_empresa e');
        $this->db->where("empresa_id", $empresa_id);
        $query = $this->db->get();
        $return2 = $query->result();

        $this->db->select('email_enviado');
        $this->db->from('tb_ambulatorio_laudo al');
        $this->db->where("ambulatorio_laudo_id", $ambulatorio_laudo_id);
        $query = $this->db->get();
        $return3 = $query->result();

        $retorno = array(
            "pacienteEmail" => $return1[0]->cns,
            "empresaEmail" => $return2[0]->email,
            "mensagem" => $return2[0]->msg,
            "enviado" => $return3[0]->email_enviado,
            "razaoSocial" => $return2[0]->razao_social
        );
        return $retorno;
    }

    function setaemailparaenviado($ambulatorio_laudo_id) {
        $this->db->set('email_enviado', 't');
        $this->db->where("ambulatorio_laudo_id", $ambulatorio_laudo_id);
        $this->db->update('tb_ambulatorio_laudo');
    }

    function gravaranamineseodontologia($ambulatorio_laudo_id, $exame_id, $procedimento_tuss_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('agenda_exames_id');
            $this->db->from('tb_exames');
            $this->db->where("exames_id", $exame_id);
            $query = $this->db->get();
            $return = $query->result();

            if ($empresa_id == null) {
                $empresa_id = $this->session->userdata('empresa_id');
            }

            $this->db->select('e.empresa_id,
                            ordem_chegada,
                            oftamologia,
                            ');
            $this->db->from('tb_empresa e');
            $this->db->where('e.empresa_id', $empresa_id);
            $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
            $this->db->orderby('e.empresa_id');
            $permissao = $this->db->get()->result();


            $this->db->select('mc.valor as perc_medico, mc.percentual');
            $this->db->from('tb_procedimento_percentual_medico_convenio mc');
            $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
            $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
            $this->db->where('mc.medico', $_POST['medico']);
            $this->db->where('mc.ativo', 'true');
            $percentual = $this->db->get()->result();

            if (count($percentual) == 0) {
                $this->db->select('pt.perc_medico, pt.percentual');
                $this->db->from('tb_procedimento_convenio pc');
                $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
//                        $this->db->where('pc.ativo', 'true');
//                        $this->db->where('pt.ativo', 'true');
                $percentual = $this->db->get()->result();
            }
            if (isset($_POST['rev'])) {
                switch ($_POST['tempoRevisao']) {
                    case '1a':
                        $dias = '+1 year';
                        break;
                    case '6m':
                        $dias = '+6 month';
                        break;
                    case '3m':
                        $dias = '+3 month';
                        break;
                    case '1m':
                        $dias = '+1 month';
                        break;
                    default:
                        $dias = '';
                }

                if ($dias != '') {
                    $diaRevisao = date('Y-m-d', strtotime($dias));
                    $this->db->set('data_revisao', $diaRevisao);
                }
            }

            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
            $this->db->set('medico_agenda', $_POST['medico']);
            $this->db->set('medico_consulta_id', $_POST['medico']);
            $this->db->where('agenda_exames_id', $return[0]->agenda_exames_id);
            $this->db->update('tb_agenda_exames');

            ////////////////////////////// OFTAMOLOGIA ///////////////////////////////////////////////
            if ($permissao[0]->oftamologia == 't') {

                $this->db->set('inspecao_geral', $_POST['inspecao_geral']);
                $this->db->set('motilidade_ocular', $_POST['motilidade_ocular']);
                $this->db->set('biomicroscopia', $_POST['biomicroscopia']);
                $this->db->set('mapeamento_retinas', $_POST['mapeamento_retinas']);
                $this->db->set('conduta', $_POST['conduta']);
                $this->db->set('acuidade_oe', $_POST['acuidade_oe']);
                $this->db->set('acuidade_od', $_POST['acuidade_od']);
                if ($_POST['pressao_ocular_oe'] != '') {
                    $this->db->set('pressao_ocular_oe', str_replace(",", ".", $_POST['pressao_ocular_oe']));
                }
                if ($_POST['pressao_ocular_od'] != '') {
                    $this->db->set('pressao_ocular_od', str_replace(",", ".", $_POST['pressao_ocular_od']));
                }
                if ($_POST['pressao_ocular_hora'] != '') {
                    $this->db->set('pressao_ocular_hora', date('H:i:s', strtotime($_POST['pressao_ocular_hora'])));
                } else {
                    $this->db->set('pressao_ocular_hora', null);
                }

                if ($_POST['refracao_retinoscopia'] != '') {
                    $this->db->set('refracao_retinoscopia', $_POST['refracao_retinoscopia']);
                } else {
                    $this->db->set('refracao_retinoscopia', '');
                }
                if ($_POST['dinamica_estatica'] != '') {
                    $this->db->set('dinamica_estatica', $_POST['dinamica_estatica']);
                } else {
                    $this->db->set('dinamica_estatica', '');
                }


                if (isset($_POST['carregar_refrator'])) {
                    $this->db->set('carregar_refrator', $_POST['carregar_refrator']);
                } else {
                    $this->db->set('carregar_refrator', 'f');
                }
                if (isset($_POST['carregar_oculos'])) {
                    $this->db->set('carregar_oculos', $_POST['carregar_oculos']);
                } else {
                    $this->db->set('carregar_oculos', 'f');
                }

//            var_dump($_POST['oftamologia_od_cilindrico']); die;
                $this->db->set('oftamologia_od_esferico', $_POST['oftamologia_od_esferico']);
                $this->db->set('oftamologia_oe_esferico', $_POST['oftamologia_oe_esferico']);
                $this->db->set('oftamologia_od_cilindrico', $_POST['oftamologia_od_cilindrico']);
                $this->db->set('oftamologia_oe_cilindrico', $_POST['oftamologia_oe_cilindrico']);
                $this->db->set('oftamologia_oe_eixo', $_POST['oftamologia_oe_eixo']);
                $this->db->set('oftamologia_oe_av', $_POST['oftamologia_oe_av']);
                $this->db->set('oftamologia_od_eixo', $_POST['oftamologia_od_eixo']);
                $this->db->set('oftamologia_od_av', $_POST['oftamologia_od_av']);
                $this->db->set('oftamologia_ad_esferico', $_POST['oftamologia_ad_esferico']);
                $this->db->set('oftamologia_ad_cilindrico', $_POST['oftamologia_ad_cilindrico']);
            }
            /////////////////////////// FIM DA OFTAMOLOGIA////////////////////////////////////////////

            $this->db->set('texto', $_POST['laudo']);
            if ($_POST['txtCICPrimario'] != '') {
                $this->db->set('cid', $_POST['txtCICPrimario']);
            }
            if ($_POST['txtCICSecundario'] != '') {
                $this->db->set('cid2', $_POST['txtCICSecundario']);
            }
            if ($_POST['medico'] != '') {
                $this->db->set('medico_parecer1', $_POST['medico']);
            }
            if ($_POST['diabetes'] != '') {
                $this->db->set('diabetes', $_POST['diabetes']);
            }
            if ($_POST['hipertensao'] != '') {
                $this->db->set('hipertensao', $_POST['hipertensao']);
            }

            if (isset($_POST['ret'])) {
                $this->db->set('dias_retorno', $_POST['ret_dias']);
            }

            if (isset($_POST['assinatura'])) {
                $this->db->set('assinatura', 't');
            } else {
                $this->db->set('assinatura', 'f');
            }
            if (isset($_POST['rodape'])) {
                $this->db->set('rodape', 't');
            } else {
                $this->db->set('rodape', 'f');
            }
            if ($_POST['status'] != 'FINALIZADO') {
                $this->db->set('data_finalizado', $horario);
                $this->db->set('operador_finalizado', $operador_id);
            }
            $this->db->set('cabecalho', $_POST['cabecalho']);
            $this->db->set('situacao', 'FINALIZADO');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('data_revisor', $horario);
            $this->db->set('operador_revisor', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');


            if ($_POST['Peso'] != '') {
                $this->db->set('peso', str_replace(",", ".", $_POST['Peso']));
            } else {
                $this->db->set('peso', null);
            }
            if ($_POST['Altura'] != '') {
                $this->db->set('altura', $_POST['Altura']);
            } else {
                $this->db->set('altura', null);
            }
            $this->db->where('ambulatorio_guia_id', $_POST['guia_id']);
            $this->db->update('tb_ambulatorio_guia');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaranaminese($ambulatorio_laudo_id, $exame_id, $procedimento_tuss_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->select('agenda_exames_id');
            $this->db->from('tb_exames');
            $this->db->where("exames_id", $exame_id);
            $query = $this->db->get();
            $return = $query->result();

            if ($empresa_id == null) {
                $empresa_id = $this->session->userdata('empresa_id');
            }

            $this->db->select('e.empresa_id,
                            ordem_chegada,
                            oftamologia,
                            ');
            $this->db->from('tb_empresa e');
            $this->db->where('e.empresa_id', $empresa_id);
            $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
            $this->db->orderby('e.empresa_id');
            $permissao = $this->db->get()->result();


            $this->db->select('mc.valor as perc_medico, mc.percentual');
            $this->db->from('tb_procedimento_percentual_medico_convenio mc');
            $this->db->join('tb_procedimento_percentual_medico m', 'm.procedimento_percentual_medico_id = mc.procedimento_percentual_medico_id', 'left');
            $this->db->where('m.procedimento_tuss_id', $procedimento_tuss_id);
            $this->db->where('mc.medico', $_POST['medico']);
            $this->db->where('mc.ativo', 'true');
            $percentual = $this->db->get()->result();

            if (count($percentual) == 0) {
                $this->db->select('pt.perc_medico, pt.percentual');
                $this->db->from('tb_procedimento_convenio pc');
                $this->db->join('tb_procedimento_tuss pt', 'pc.procedimento_tuss_id = pt.procedimento_tuss_id', 'left');
                $this->db->where('pc.procedimento_convenio_id', $procedimento_tuss_id);
//                        $this->db->where('pc.ativo', 'true');
//                        $this->db->where('pt.ativo', 'true');
                $percentual = $this->db->get()->result();
            }
            if (isset($_POST['rev'])) {
                switch ($_POST['tempoRevisao']) {
                    case '1a':
                        $dias = '+1 year';
                        break;
                    case '6m':
                        $dias = '+6 month';
                        break;
                    case '3m':
                        $dias = '+3 month';
                        break;
                    case '1m':
                        $dias = '+1 month';
                        break;
                    default:
                        $dias = '';
                }

                if ($dias != '') {
                    $diaRevisao = date('Y-m-d', strtotime($dias));
                    $this->db->set('data_revisao', $diaRevisao);
                }
            }

            $this->db->set('valor_medico', $percentual[0]->perc_medico);
            $this->db->set('percentual_medico', $percentual[0]->percentual);
            $this->db->set('medico_agenda', $_POST['medico']);
            $this->db->set('medico_consulta_id', $_POST['medico']);
            $this->db->where('agenda_exames_id', $return[0]->agenda_exames_id);
            $this->db->update('tb_agenda_exames');

            ////////////////////////////// OFTAMOLOGIA ///////////////////////////////////////////////
            if ($permissao[0]->oftamologia == 't') {

                $this->db->set('inspecao_geral', $_POST['inspecao_geral']);
                $this->db->set('motilidade_ocular', $_POST['motilidade_ocular']);
                $this->db->set('biomicroscopia', $_POST['biomicroscopia']);
                $this->db->set('mapeamento_retinas', $_POST['mapeamento_retinas']);
                $this->db->set('conduta', $_POST['conduta']);
                $this->db->set('acuidade_oe', $_POST['acuidade_oe']);
                $this->db->set('acuidade_od', $_POST['acuidade_od']);
                if ($_POST['pressao_ocular_oe'] != '') {
                    $this->db->set('pressao_ocular_oe', str_replace(",", ".", $_POST['pressao_ocular_oe']));
                }
                if ($_POST['pressao_ocular_od'] != '') {
                    $this->db->set('pressao_ocular_od', str_replace(",", ".", $_POST['pressao_ocular_od']));
                }
                if ($_POST['pressao_ocular_hora'] != '') {
                    $this->db->set('pressao_ocular_hora', date('H:i:s', strtotime($_POST['pressao_ocular_hora'])));
                } else {
                    $this->db->set('pressao_ocular_hora', null);
                }

                if ($_POST['refracao_retinoscopia'] != '') {
                    $this->db->set('refracao_retinoscopia', $_POST['refracao_retinoscopia']);
                } else {
                    $this->db->set('refracao_retinoscopia', '');
                }
                if ($_POST['dinamica_estatica'] != '') {
                    $this->db->set('dinamica_estatica', $_POST['dinamica_estatica']);
                } else {
                    $this->db->set('dinamica_estatica', '');
                }


                if (isset($_POST['carregar_refrator'])) {
                    $this->db->set('carregar_refrator', $_POST['carregar_refrator']);
                } else {
                    $this->db->set('carregar_refrator', 'f');
                }
                if (isset($_POST['carregar_oculos'])) {
                    $this->db->set('carregar_oculos', $_POST['carregar_oculos']);
                } else {
                    $this->db->set('carregar_oculos', 'f');
                }

//            var_dump($_POST['oftamologia_od_cilindrico']); die;
                $this->db->set('oftamologia_od_esferico', $_POST['oftamologia_od_esferico']);
                $this->db->set('oftamologia_oe_esferico', $_POST['oftamologia_oe_esferico']);
                $this->db->set('oftamologia_od_cilindrico', $_POST['oftamologia_od_cilindrico']);
                $this->db->set('oftamologia_oe_cilindrico', $_POST['oftamologia_oe_cilindrico']);
                $this->db->set('oftamologia_oe_eixo', $_POST['oftamologia_oe_eixo']);
                $this->db->set('oftamologia_oe_av', $_POST['oftamologia_oe_av']);
                $this->db->set('oftamologia_od_eixo', $_POST['oftamologia_od_eixo']);
                $this->db->set('oftamologia_od_av', $_POST['oftamologia_od_av']);
                $this->db->set('oftamologia_ad_esferico', $_POST['oftamologia_ad_esferico']);
                $this->db->set('oftamologia_ad_cilindrico', $_POST['oftamologia_ad_cilindrico']);
            }
            /////////////////////////// FIM DA OFTAMOLOGIA////////////////////////////////////////////

            $this->db->set('texto', $_POST['laudo']);


            if ($_POST['adendo'] != '') {
                $adendo_coluna = "<p>Adendo de: " . date("d/m/Y H:i:s") . "<br></p>" . $_POST['adendo'];
                $adendo = $_POST['laudo'] . "<p><strong>Adendo de: " . date("d/m/Y H:i:s") . "<br></strong></p>" . $_POST['adendo'];
//                $this->db->set('adendo', $adendo_coluna);
                $this->db->set("texto", $adendo);
            }
//            var_dump($adendo);
//            die;
            if ($_POST['txtCICPrimario'] != '') {
                $this->db->set('cid', $_POST['txtCICPrimario']);
            }
            if ($_POST['txtCICSecundario'] != '') {
                $this->db->set('cid2', $_POST['txtCICSecundario']);
            }
            if ($_POST['medico'] != '') {
                $this->db->set('medico_parecer1', $_POST['medico']);
            }
            if ($_POST['diabetes'] != '') {
                $this->db->set('diabetes', $_POST['diabetes']);
            }
            if ($_POST['hipertensao'] != '') {
                $this->db->set('hipertensao', $_POST['hipertensao']);
            }

            if (isset($_POST['ret'])) {
                $this->db->set('dias_retorno', $_POST['ret_dias']);
            }

            if (isset($_POST['assinatura'])) {
                $this->db->set('assinatura', 't');
            } else {
                $this->db->set('assinatura', 'f');
            }
            if (isset($_POST['rodape'])) {
                $this->db->set('rodape', 't');
            } else {
                $this->db->set('rodape', 'f');
            }
            if ($_POST['status'] != 'FINALIZADO') {
                $this->db->set('data_finalizado', $horario);
                $this->db->set('operador_finalizado', $operador_id);
            }
            $this->db->set('cabecalho', $_POST['cabecalho']);
            $this->db->set('situacao', 'FINALIZADO');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('data_revisor', $horario);
            $this->db->set('operador_revisor', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');


            if ($_POST['Peso'] != '') {
                $this->db->set('peso', str_replace(",", ".", $_POST['Peso']));
            } else {
                $this->db->set('peso', null);
            }
            if ($_POST['Altura'] != '') {
                $this->db->set('altura', $_POST['Altura']);
            } else {
                $this->db->set('altura', null);
            }
            $this->db->where('ambulatorio_guia_id', $_POST['guia_id']);
            $this->db->update('tb_ambulatorio_guia');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarreceitaoculosimpressao($ambulatorio_laudo_id) {

        $this->db->select('ag.ambulatorio_laudo_id,
                          ag.paciente_id,
                          ag.data_cadastro,
                          ag.exame_id,
                          ag.peso,
                          ag.altura,
                          ag.data_cadastro,
                          ag.data,
                          ag.situacao,
                          ae.agenda_exames_nome_id,
                          ag.inspecao_geral,
                          ag.motilidade_ocular,
                          ag.biomicroscopia,
                          ag.mapeamento_retinas,
                          ag.conduta,
                          ag.acuidade_od,
                          ag.acuidade_oe,
                          ag.pressao_ocular_oe,
                          ag.pressao_ocular_od,
                          ag.pressao_ocular_hora,
                          ag.refracao_retinoscopia,
                          ag.dinamica_estatica,
                          ag.carregar_refrator,
                          ag.carregar_oculos,
                          ag.oftamologia_od_esferico,
                          ag.oftamologia_oe_esferico,
                          ag.oftamologia_od_cilindrico,
                          ag.oftamologia_oe_cilindrico,
                          ag.oftamologia_oe_eixo,
                          ag.oftamologia_oe_av,
                          ag.oftamologia_od_eixo,
                          ag.oftamologia_od_av,
                          ag.oftamologia_ad_esferico,
                          ag.oftamologia_ad_cilindrico,
                          p.nascimento,
                          ag.situacao_revisor,
                          o.nome as medico,
                          o.conselho,
                          ag.assinatura,
                          ag.rodape,
                          ag.guia_id,
                          ag.cabecalho,
                          ag.medico_parecer1,
                          ag.medico_parecer2,
                          me.nome as solicitante,
                          op.nome as medicorevisor,
                          pt.nome as procedimento,
                          pt.grupo,
                          ae.agenda_exames_id,
                          ag.imagens,
                          c.nome as convenio,
                          pc.convenio_id,
                          p.nome as paciente,
                          p.cpf,
                          p.nascimento,
                          p.sexo,
                          o.carimbo as medico_carimbo');
        $this->db->from('tb_ambulatorio_laudo ag');
        //        $this->db->join('tb_ambulatorio_laudo ag', 'ag.ambulatorio_laudo_id = ar.laudo_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->join('tb_exames e', 'e.exames_id = ag.exame_id ', 'left');
        $this->db->join('tb_agenda_exames ae', 'ae.agenda_exames_id = e.agenda_exames_id', 'left');
        $this->db->join('tb_operador me', 'me.operador_id = ae.medico_solicitante', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_convenio c', 'pc.convenio_id = c.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("ag.ambulatorio_laudo_id", $ambulatorio_laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function gravarreceituario() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto', $_POST['laudo']);
            if ($_POST['carimbo'] == "on") {
                $this->db->set('carimbo', 't');
            }
            if ($_POST['assinatura'] == "on") {
                $this->db->set('assinatura', 't');
            }
//            $this->db->set('paciente_id', $_POST['paciente_id']);
//            $this->db->set('procedimento_tuss_id', $_POST['procedimento_tuss_id']);
            $this->db->set('laudo_id', $_POST['ambulatorio_laudo_id']);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $_POST['medico']);
            $this->db->set('tipo', 'NORMAL');

            $this->db->insert('tb_ambulatorio_receituario');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function preencherformulario($paciente_id, $guia_id) {

        $this->db->select('*');
        $this->db->from('tb_laudo_form lf');
        $this->db->where('lf.guia_id', $guia_id);
        $this->db->where('lf.paciente_id', $paciente_id);
        $return = $this->db->get();
        $result = $return->result();
        return $result;
    }
    
    function preencheravaliacao($paciente_id, $guia_id) {

        $this->db->select('*');
        $this->db->from('tb_laudo_avaliacao la');
        $this->db->where('la.guia_id', $guia_id);
        $this->db->where('la.paciente_id', $paciente_id);
        $return = $this->db->get();
        $result = $return->result();
        return $result;
    }

    function gravarformulario() {
        try {
            $paciente_id = $this->session->userdata('paciente_id');
            //         $this->db->set('paciente_id', $_POST['paciente_id']);
            $guia_id = $this->session->userdata('guia_id');
            //         $this->db->set('guia_id', $_POST['guia_id']);

            $perguntas_form = array(
                "pergunta1" => $_POST["pergunta1"],
                "pergunta2" => $_POST["pergunta2"],
                "pergunta3" => $_POST["pergunta3"],
                "pergunta4" => $_POST["pergunta4"],
                "pergunta5" => $_POST["pergunta5"],
                "pergunta6" => $_POST["pergunta6"],
                "pergunta7" => $_POST["pergunta7"],
                "pergunta8" => $_POST["pergunta8"],
                "pergunta9" => $_POST["pergunta9"],
                "pergunta10" => $_POST["pergunta10"],
                "pergunta11" => $_POST["pergunta11"]
            );


            $this->db->select('lf.guia_id, lf.paciente_id');
            $this->db->from('tb_laudo_form lf');
            $this->db->where('lf.guia_id', $_POST['guia_id']);
            $this->db->where('lf.paciente_id', $_POST['paciente_id']);
            $return = $this->db->get();
            $result = $return->result();

            if (count($result) > 0) {
                $this->db->set('paciente_id', $_POST['paciente_id']);
                $this->db->set('guia_id', $_POST['guia_id']);

                if (count($perguntas_form) > 0) {
                    $this->db->set('questoes', json_encode($perguntas_form));
                } else {
                    $this->db->set('questoes', '');
                }

                if ($_POST['obesidade'] != '') {
                    $this->db->set('obesidade', $_POST['obesidade']);
                }
                if ($_POST['diabetes'] != '') {
                    $this->db->set('diabetes', $_POST['diabetes']);
                }
                if ($_POST['sedentarismo'] != '') {
                    $this->db->set('sedentarismo', $_POST['sedentarismo']);
                }
                if ($_POST['hipertensao'] != '') {
                    $this->db->set('hipertensao', $_POST['hipertensao']);
                }
                if ($_POST['dac'] != '') {
                    $this->db->set('dac', $_POST['dac']);
                }
                if ($_POST['tabagismo'] != '') {
                    $this->db->set('tabagismo', $_POST['tabagismo']);
                }
                if ($_POST['dislipidemia'] != '') {
                    $this->db->set('dislipidemia', $_POST['dislipidemia']);
                }
                if ($_POST['diabetespe'] != '') {
                    $this->db->set('diabetespe', $_POST['diabetespe']);
                }
                if ($_POST['haspe'] != '') {
                    $this->db->set('haspe', $_POST['haspe']);
                }
                if ($_POST['dacpe'] != '') {
                    $this->db->set('dacpe', $_POST['dacpe']);
                }
                if ($_POST['ircpe'] != '') {
                    $this->db->set('ircpe', $_POST['ircpe']);
                }
                if ($_POST['sopros'] != '') {
                    $this->db->set('sopros', $_POST['sopros']);
                }

                $this->db->update('tb_laudo_form');
            } else {
                if (count($perguntas_form) > 0) {
                    $this->db->set('questoes', json_encode($perguntas_form));
                } else {
                    $this->db->set('questoes', '');
                }

                if ($_POST['obesidade'] != '') {
                    $this->db->set('obesidade', $_POST['obesidade']);
                }
                if ($_POST['diabetes'] != '') {
                    $this->db->set('diabetes', $_POST['diabetes']);
                }
                if ($_POST['sedentarismo'] != '') {
                    $this->db->set('sedentarismo', $_POST['sedentarismo']);
                }
                if ($_POST['hipertensao'] != '') {
                    $this->db->set('hipertensao', $_POST['hipertensao']);
                }
                if ($_POST['dac'] != '') {
                    $this->db->set('dac', $_POST['dac']);
                }
                if ($_POST['tabagismo'] != '') {
                    $this->db->set('tabagismo', $_POST['tabagismo']);
                }
                if ($_POST['dislipidemia'] != '') {
                    $this->db->set('dislipidemia', $_POST['dislipidemia']);
                }
                if ($_POST['diabetespe'] != '') {
                    $this->db->set('diabetespe', $_POST['diabetespe']);
                }
                if ($_POST['haspe'] != '') {
                    $this->db->set('haspe', $_POST['haspe']);
                }
                if ($_POST['dacpe'] != '') {
                    $this->db->set('dacpe', $_POST['dacpe']);
                }
                if ($_POST['ircpe'] != '') {
                    $this->db->set('ircpe', $_POST['ircpe']);
                }
                if ($_POST['sopros'] != '') {
                    $this->db->set('sopros', $_POST['sopros']);
                }
                $this->db->set('paciente_id', $_POST['paciente_id']);
                $this->db->set('guia_id', $_POST['guia_id']);
                $this->db->insert('tb_laudo_form');
            }
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaravaliacao() {
        try {
            $paciente_id = $this->session->userdata('paciente_id');
            $guia_id = $this->session->userdata('guia_id');
            //       $this->db->set('paciente_id', $_POST['paciente_id']);

            $criterios_tb1 = array(
                "c1tb1" => $_POST["c1tb1"],
                "c2tb1" => $_POST["c2tb1"],
                "c3tb1" => $_POST["c3tb1"],
                "c4tb1" => $_POST["c4tb1"],
                "c5tb1" => $_POST["c5tb1"],
                "c6tb1" => $_POST["c6tb1"]
            );
            $criterios_tb2 = array(
                "c1tb2" => $_POST["c1tb2"],
                "c2tb2" => $_POST["c2tb2"],
                "c3tb2" => $_POST["c3tb2"],
                "c4tb2" => $_POST["c4tb2"],
                "c5tb2" => $_POST["c5tb2"],
                "c6tb2" => $_POST["c6tb2"],
                "c7tb2" => $_POST["c7tb2"],
                "c8tb2" => $_POST["c8tb2"],
                "c9tb2" => $_POST["c9tb2"],
                "c10tb2" => $_POST["c10tb2"],
                "c11tb2" => $_POST["c11tb2"],
                "c12tb2" => $_POST["c12tb2"]
            );
            $criterios_tb3 = array(
                "c1tb3" => $_POST["c1tb3"],
                "c2tb3" => $_POST["c2tb3"],
                "c3tb3" => $_POST["c3tb3"],
                "c4tb3" => $_POST["c4tb3"],
                "c5tb3" => $_POST["c5tb3"],
                "c6tb3" => $_POST["c6tb3"],
                "c7tb3" => $_POST["c7tb3"],
                "c8tb3" => $_POST["c8tb3"]
            );
            $criterios_tb4 = array(
                "riscoalto" => $_POST["riscoalto"],
                "riscomedio" => $_POST["riscomedio"],
                "riscobaixo" => $_POST["riscobaixo"]
            );
            $this->db->select('la.guia_id, la.paciente_id');
            $this->db->from('tb_laudo_avaliacao la');
            $this->db->where('la.guia_id', $_POST['guia_id']);
            $this->db->where('la.paciente_id', $_POST['paciente_id']);
            $return = $this->db->get();
            $result = $return->result();

            if (count($result) > 0) {
                $this->db->set('paciente_id', $_POST['paciente_id']);
                $this->db->set('guia_id', $_POST['guia_id']);

                if (count($criterios_tb1) > 0) {
                    $this->db->set('avaliacao_tabela1', json_encode($criterios_tb1));
                } else {
                    $this->db->set('avaliacao_tabela1', '');
                }
                if (count($criterios_tb2) > 0) {
                    $this->db->set('avaliacao_tabela2', json_encode($criterios_tb2));
                } else {
                    $this->db->set('avaliacao_tabela2', '');
                }
                if (count($criterios_tb3) > 0) {
                    $this->db->set('avaliacao_tabela3', json_encode($criterios_tb3));
                } else {
                    $this->db->set('avaliacao_tabela3', '');
                }
                if (count($criterios_tb4) > 0) {
                    $this->db->set('avaliacao_tabela4', json_encode($criterios_tb4));
                } else {
                    $this->db->set('avaliacao_tabela4', '');
                }

                $this->db->update('tb_laudo_avaliacao');
            } else {
                $this->db->set('paciente_id', $_POST['paciente_id']);
                $this->db->set('guia_id', $_POST['guia_id']);

                if (count($criterios_tb1) > 0) {
                    $this->db->set('avaliacao_tabela1', json_encode($criterios_tb1));
                } else {
                    $this->db->set('avaliacao_tabela1', '');
                }
                if (count($criterios_tb2) > 0) {
                    $this->db->set('avaliacao_tabela2', json_encode($criterios_tb2));
                } else {
                    $this->db->set('avaliacao_tabela2', '');
                }
                if (count($criterios_tb3) > 0) {
                    $this->db->set('avaliacao_tabela3', json_encode($criterios_tb3));
                } else {
                    $this->db->set('avaliacao_tabela3', '');
                }
                if (count($criterios_tb4) > 0) {
                    $this->db->set('avaliacao_tabela4', json_encode($criterios_tb3));
                } else {
                    $this->db->set('avaliacao_tabela4', '');
                }

                $this->db->insert('tb_laudo_avaliacao');
            }
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaratestado() {
        try {
//            var_dump($_POST['cid1ID']);
//            die;
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto', $_POST['laudo']);
            if ($_POST['carimbo'] == "on") {
                $this->db->set('carimbo', 't');
            }
            if ($_POST['assinatura'] == "on") {
                $this->db->set('assinatura', 't');
            }

            $this->db->set('laudo_id', $_POST['ambulatorio_laudo_id']);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $_POST['medico']);
            if ($_POST['data'] != "") {
                $this->db->set('data', $_POST['data']);
            }
            if ($_POST['cid1ID'] != "") {
                $this->db->set('cid1', $_POST['cid1ID']);
            }
            if ($_POST['cid2ID'] != "") {
                $this->db->set('cid2', $_POST['cid2ID']);
            }
            if ($_POST['imprimircid'] == "on") {
                $this->db->set('imprimir_cid', 't');
            }
            $this->db->set('tipo', 'NORMAL');

            $this->db->insert('tb_ambulatorio_atestado');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarexame() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto', $_POST['laudo']);

            if ($_POST['carimbo'] == "on") {
                $this->db->set('carimbo', 't');
            }
            if ($_POST['assinatura'] == "on") {
                $this->db->set('assinatura', 't');
            }
//            $this->db->set('paciente_id', $_POST['paciente_id']);
//            $this->db->set('procedimento_tuss_id', $_POST['procedimento_tuss_id']);
            $this->db->set('laudo_id', $_POST['ambulatorio_laudo_id']);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $_POST['medico']);
            $this->db->set('tipo', 'NORMAL');

            $this->db->insert('tb_ambulatorio_exame');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarreceituarioespecial() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto', $_POST['laudo']);
//            $this->db->set('paciente_id', $_POST['paciente_id']);
//            $this->db->set('procedimento_tuss_id', $_POST['procedimento_tuss_id']);
            if ($_POST['carimbo'] == "on") {
                $this->db->set('carimbo', 't');
            }
            if ($_POST['assinatura'] == "on") {
                $this->db->set('assinatura', 't');
            }
            $this->db->set('laudo_id', $_POST['ambulatorio_laudo_id']);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $_POST['medico']);
            $this->db->set('tipo', 'ESPECIAL');

            $this->db->insert('tb_ambulatorio_receituario_especial');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function editarreceituarioespecial() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto', $_POST['laudo']);
//            $this->db->set('paciente_id', $_POST['paciente_id']);
//            $this->db->set('procedimento_tuss_id', $_POST['procedimento_tuss_id']);
            $this->db->set('laudo_id', $_POST['ambulatorio_laudo_id']);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_receituario_especial_id', $_POST['receituario_id']);
            $this->db->update('tb_ambulatorio_receituario_especial');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function editarreceituario() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto', $_POST['laudo']);
//            $this->db->set('paciente_id', $_POST['paciente_id']);
//            $this->db->set('procedimento_tuss_id', $_POST['procedimento_tuss_id']);
            $this->db->set('laudo_id', $_POST['ambulatorio_laudo_id']);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_receituario_id', $_POST['receituario_id']);
            $this->db->update('tb_ambulatorio_receituario');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function repetirreceituario() {
        try {

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto', $_POST['laudo']);

            $this->db->set('laudo_id', $_POST['ambulatorio_laudo_id']);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $_POST['medico']);
            $this->db->set('tipo', 'NORMAL');
            $this->db->where('ambulatorio_receituario_id', $_POST['receituario_id']);
            $this->db->insert('tb_ambulatorio_receituario');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function editaratestado() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto', $_POST['laudo']);
//            $this->db->set('paciente_id', $_POST['paciente_id']);
//            $this->db->set('procedimento_tuss_id', $_POST['procedimento_tuss_id']);
            $this->db->set('laudo_id', $_POST['ambulatorio_laudo_id']);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_atestado_id', $_POST['receituario_id']);
            $this->db->update('tb_ambulatorio_atestado');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function editarsolicitarexame() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto', $_POST['laudo']);
//            $this->db->set('paciente_id', $_POST['paciente_id']);
//            $this->db->set('procedimento_tuss_id', $_POST['procedimento_tuss_id']);
            $this->db->set('laudo_id', $_POST['ambulatorio_laudo_id']);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_exame_id', $_POST['receituario_id']);
            $this->db->update('tb_ambulatorio_exame');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaranaminesedigitando($ambulatorio_laudo_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto', $_POST['laudo']);
            if ($_POST['medico'] != '') {
                $this->db->set('medico_parecer1', $_POST['medico']);
            }
            if ($_POST['txtCICPrimario'] != '') {
                $this->db->set('cid', $_POST['txtCICPrimario']);
            }
            if (isset($_POST['assinatura'])) {
                $this->db->set('assinatura', 't');
            } else {
                $this->db->set('assinatura', 'f');
            }
            if (isset($_POST['rodape'])) {
                $this->db->set('rodape', 't');
            } else {
                $this->db->set('rodape', 'f');
            }
            $this->db->set('cabecalho', $_POST['cabecalho']);
            $this->db->set('situacao', 'DIGITANDO');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarlaudotodos($ambulatorio_laudo_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if (isset($_POST['revisor'])) {
                $this->db->set('revisor', 't');
                $this->db->set('situacao_revisor', 'AGUARDANDO');
            } else {
                $this->db->set('revisor', 'f');
            }
            $this->db->set('texto_laudo', $_POST['laudo']);
            $this->db->set('texto', $_POST['laudo']);
            if ($_POST['medico'] != '') {
                $this->db->set('medico_parecer1', $_POST['medico']);
            }
            if ($_POST['medicorevisor'] != '') {
                $this->db->set('medico_parecer2', $_POST['medicorevisor']);
            } else {
                $this->db->set('medico_parecer2', null);
            }
            if (isset($_POST['assinatura'])) {
                $this->db->set('assinatura', 't');
            } else {
                $this->db->set('assinatura', 'f');
            }
            if (isset($_POST['rodape'])) {
                $this->db->set('rodape', 't');
            } else {
                $this->db->set('rodape', 'f');
            }
            $this->db->set('cabecalho', $_POST['cabecalho']);
            if (isset($_POST['imagem'])) {
                $this->db->set('imagens', $_POST['imagem']);
            }
            $this->db->set('situacao', 'FINALIZADO');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarlaudodigitandotodos($ambulatorio_laudo_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            if (isset($_POST['revisor'])) {
                $this->db->set('revisor', 't');
                $this->db->set('situacao_revisor', 'AGUARDANDO');
            } else {
                $this->db->set('revisor', 'f');
            }
            $this->db->set('texto_laudo', $_POST['laudo']);
            $this->db->set('texto', $_POST['laudo']);
            if ($_POST['medico'] != '') {
                $this->db->set('medico_parecer1', $_POST['medico']);
            }
            if ($_POST['medicorevisor'] != '') {
                $this->db->set('medico_parecer2', $_POST['medicorevisor']);
            } else {
                $this->db->set('medico_parecer2', null);
            }
            if (isset($_POST['assinatura'])) {
                $this->db->set('assinatura', 't');
            } else {
                $this->db->set('assinatura', 'f');
            }
            if (isset($_POST['rodape'])) {
                $this->db->set('rodape', 't');
            } else {
                $this->db->set('rodape', 'f');
            }
            $this->db->set('cabecalho', $_POST['cabecalho']);
            if (isset($_POST['imagem'])) {
                $this->db->set('imagens', $_POST['imagem']);
            }
            $this->db->set('situacao', 'DIGITANDO');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarrevisao($ambulatorio_laudo_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto_revisor', $_POST['laudo']);
            $this->db->set('texto', $_POST['laudo']);
            $this->db->set('medico_parecer2', $_POST['medicorevisor']);
            $this->db->set('situacao_revisor', $_POST['situacao']);
            $this->db->set('situacao', $_POST['situacao']);
            $this->db->set('data_revisor', $horario);
            $this->db->set('operador_revisor', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravaralterardata($ambulatorio_laudo_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $hora = date("H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $dataautorizacao = $_POST['data'] . " " . $hora;
//            var_dump($dataautorizacao);
//            die;
            $sql = "UPDATE ponto.tb_ambulatorio_laudo
                    SET data_antiga = data_cadastro
                    WHERE ambulatorio_laudo_id = $ambulatorio_laudo_id;";

            $this->db->query($sql);

//            $this->db->set('data_antiga', 'data');
//            $this->db->set('data_aterardatafaturamento', $horario);
//            $this->db->set('data_autorizacao', $dataautorizacao);
            $this->db->set('operador_alteradata', $operador_id);
            $this->db->set('data_cadastro', $_POST['data']);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarrevisaodigitando($ambulatorio_laudo_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto_revisor', $_POST['laudo']);
            $this->db->set('texto', $_POST['laudo']);
            $this->db->set('medico_parecer2', $_POST['medicorevisor']);
            $this->db->set('situacao_revisor', $_POST['situacao']);
            if ($_POST['situacao'] != 'FINALIZADO') {
                $this->db->set('situacao', $_POST['situacao']);
            } else {
                $this->db->set('situacao', 'DIGITANDO');
            }
            $this->db->set('data_revisor', $horario);
            $this->db->set('operador_revisor', $operador_id);
            $this->db->where('ambulatorio_laudo_id', $ambulatorio_laudo_id);
            $this->db->update('tb_ambulatorio_laudo');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function gravarexames() {
        try {
            $this->db->set('convenio_id', $_POST['convenio']);
            $this->db->where('ambulatorio_laudo_id', $_POST['txtlaudo_id']);
            $this->db->update('tb_ambulatorio_laudo');
            $i = -1;
            foreach ($_POST['procedimento'] as $procedimento_tuss_id) {
                $z = -1;
                $i++;
                foreach ($_POST['valor'] as $itemnome) {
                    $z++;
                    if ($i == $z) {
                        $valor = $itemnome;
                        break;
                    }
                }
                $hora = date("H:i:s");
                $data = date("Y-m-d");
                $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
                $this->db->set('valor', $valor);
                $this->db->set('inicio', $hora);
                $this->db->set('fim', $hora);
                $this->db->set('confirmado', 't');
                $this->db->set('ativo', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('laudo_id', $_POST['txtlaudo_id']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('paciente_id', $_POST['txtpaciente_id']);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('data', $data);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_agenda_exames');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return -1;
                } else {
                    $agenda_exames_id = $this->db->insert_id();
                }
            }
            return $agenda_exames_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($ambulatorio_laudo_id) {

        if ($ambulatorio_laudo_id != 0) {
            $this->db->select('ag.ambulatorio_laudo_id,
                            ag.paciente_id,
                            ag.data_cadastro,
                            ag.texto,
                            ag.medico_parecer1,
                            ag.medico_parecer2,
                            ag.id_chamada,
                            ag.revisor,
                            ag.diabetes,
                            ag.hipertensao,
                            p.nome,
                            pt.nome as procedimento,
                            p.idade,
                            age.data,
                            age.agenda_exames_id,
                            age.quantidade,
                            age.agrupador_fisioterapia,
                            age.atendimento,
                            ag.assinatura,
                            ag.cabecalho,
                            ag.situacao,
                            ag.imagens,
                            ag.rodape,
                            o.nome as solicitante,
                            ae.sala_id,
                            pt.grupo,
                            p.nascimento,
                            pc.convenio_id,
                            
                            ag.cid,
                            ag.cid2,
                            agi.peso,
                            agi.altura,
                            agi.pasistolica,
                            agi.padiastolica,
                            
                            ag.inspecao_geral,
                            ag.motilidade_ocular,
                            ag.biomicroscopia,
                            ag.mapeamento_retinas,
                            ag.conduta,

                            ag.acuidade_od,
                            ag.acuidade_oe,
                            ag.pressao_ocular_oe,
                            ag.pressao_ocular_od,
                            ag.pressao_ocular_hora,

                            ag.refracao_retinoscopia,
                            ag.dinamica_estatica,
                            ag.carregar_refrator,
                            ag.carregar_oculos,

                            ag.oftamologia_od_esferico,
                            ag.oftamologia_oe_esferico,
                            ag.oftamologia_od_cilindrico,
                            ag.oftamologia_oe_cilindrico,
                            ag.oftamologia_oe_eixo,
                            ag.oftamologia_oe_av,
                            ag.oftamologia_od_eixo,
                            ag.oftamologia_od_av,
                            ag.oftamologia_ad_esferico,
                            ag.oftamologia_ad_cilindrico,
                            
                            ag.superficie_corporea,
                            ag.ve_volume_telediastolico,
                            ag.ve_volume_telessistolico,
                            ag.ve_diametro_telediastolico,
                            ag.ve_diametro_telessistolico,
                            ag.ve_indice_do_diametro_diastolico,
                            ag.ve_septo_interventricular,
                            ag.ve_parede_posterior,
                            ag.ve_relacao_septo_parede_posterior,
                            ag.ve_espessura_relativa_paredes,
                            ag.ve_massa_ventricular,
                            ag.ve_indice_massa,
                            ag.ve_relacao_volume_massa,
                            ag.ve_fracao_ejecao,
                            ag.ve_fracao_encurtamento,
                            ag.vd_diametro_telediastolico,
                            ag.vd_area_telediastolica,
                            ag.vd_diametro_pel,
                            ag.vd_diametro_basal,
                            ag.ve_volume_telessistolico,
                            ag.ae_diametro,
                            ag.ad_volume,
                            ag.ad_volume_indexado,
                            ag.ae_volume,
                            ag.ao_diametro_raiz,
                            ag.ao_relacao_atrio_esquerdo_aorta,
                            ag.dias_retorno,
                            ag.medico_encaminhamento_id,
                            ag.adendo,
                            c.no_cid,
                            c2.no_cid as no_cid2,
                            ae.exames_id,
                            ae.indicado,
                            es.nome as sala,
                            p.sexo,
                            p.paciente_id,
                            p.logradouro,
                            p.telefone,
                            p.numero,
                            p.bairro,
                            p.senha,
                            p.estado_civil_id,
                            cbo.descricao as profissao_cbo,
                            ag.toten_fila_id,
                            ag.toten_senha_id,
                            ag.data_senha,
                            o2.nome as medico_nome,
                            p.cpf,
                            es.toten_sala_id,
                            pi.nome as indicacao,
                            m.estado as uf,
                            age.guia_id,
                            age.medico_solicitante,
                            ag.primeiro_atendimento,
                            co.nome as convenio,
                            ag.situacao as situacaolaudo,
                            p.nome as paciente');
            $this->db->from('tb_ambulatorio_laudo ag');
            $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
            $this->db->join('tb_cbo_ocupacao cbo', 'cbo.cbo_ocupacao_id = p.profissao', 'left');
            $this->db->join('tb_paciente_indicacao pi', 'pi.paciente_indicacao_id = p.indicacao', 'left');
            $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
            $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
            $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
            $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.sala_id', 'left');
            $this->db->join('tb_ambulatorio_guia agi', 'agi.ambulatorio_guia_id = ae.guia_id', 'left');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
            $this->db->join('tb_convenio co', 'co.convenio_id = pc.convenio_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_cid c', 'c.co_cid = ag.cid', 'left');
            $this->db->join('tb_cid c2', 'c2.co_cid = ag.cid2', 'left');
            $this->db->join('tb_operador o', 'o.operador_id = age.medico_solicitante', 'left');
            $this->db->join('tb_operador o2', 'o2.operador_id = ag.medico_parecer1', 'left');
            $this->db->where("ambulatorio_laudo_id", $ambulatorio_laudo_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ambulatorio_laudo_id = $ambulatorio_laudo_id;
            $this->_indicado = $return[0]->indicado;
            $this->_indicacao = $return[0]->indicacao;
            $this->_situacaolaudo = $return[0]->situacaolaudo;
            $this->_agenda_exames_id = $return[0]->agenda_exames_id;
            $this->_atendimento = $return[0]->atendimento;
            $this->_paciente_id = $return[0]->paciente_id;
            $this->_cpf = $return[0]->cpf;
            $this->_profissao_cbo = $return[0]->profissao_cbo;
            $this->_estado_civil_id = $return[0]->estado_civil_id;
            $this->_logradouro = $return[0]->logradouro;
            $this->_numero = $return[0]->numero;
            $this->_id_chamada = $return[0]->id_chamada;
            $this->_bairro = $return[0]->bairro;
            $this->_medico_solicitante = $return[0]->medico_solicitante;
            $this->_primeiro_atendimento = $return[0]->primeiro_atendimento;
            $this->_adendo = $return[0]->adendo;
            $this->_uf = $return[0]->uf;
            $this->_telefone = $return[0]->telefone;
            $this->_texto = $return[0]->texto;
            $this->_medico_parecer1 = $return[0]->medico_parecer1;
            $this->_medico_parecer2 = $return[0]->medico_parecer2;
            $this->_revisor = $return[0]->revisor;
            $this->_grupo = $return[0]->grupo;
            $this->_sala = $return[0]->sala;
            $this->_sala_id = $return[0]->sala_id;
            $this->_guia_id = $return[0]->guia_id;
            $this->_nome = $return[0]->nome;
            $this->_senha = $return[0]->senha;
            $this->_toten_fila_id = $return[0]->toten_fila_id;
            $this->_toten_senha_id = $return[0]->toten_senha_id;
            $this->_data_senha = $return[0]->data_senha;
            $this->_medico_nome = $return[0]->medico_nome;
            $this->_toten_sala_id = $return[0]->toten_sala_id;
            ///////////// OFTAMOLOGIA////////////
            $this->_oftamologia_od_esferico = $return[0]->oftamologia_od_esferico;
            $this->_oftamologia_oe_esferico = $return[0]->oftamologia_oe_esferico;
            $this->_oftamologia_od_cilindrico = $return[0]->oftamologia_od_cilindrico;
            $this->_oftamologia_oe_cilindrico = $return[0]->oftamologia_oe_cilindrico;
            $this->_oftamologia_oe_eixo = $return[0]->oftamologia_oe_eixo;
            $this->_oftamologia_oe_av = $return[0]->oftamologia_oe_av;
            $this->_oftamologia_od_eixo = $return[0]->oftamologia_od_eixo;
            $this->_oftamologia_od_av = $return[0]->oftamologia_od_av;
            $this->_oftamologia_ad_esferico = $return[0]->oftamologia_ad_esferico;
            $this->_oftamologia_ad_cilindrico = $return[0]->oftamologia_ad_cilindrico;
            $this->_inspecao_geral = $return[0]->inspecao_geral;
            $this->_motilidade_ocular = $return[0]->motilidade_ocular;
            $this->_biomicroscopia = $return[0]->biomicroscopia;
            $this->_mapeamento_retinas = $return[0]->mapeamento_retinas;
            $this->_conduta = $return[0]->conduta;
            $this->_acuidade_od = $return[0]->acuidade_od;
            $this->_acuidade_oe = $return[0]->acuidade_oe;
            $this->_pressao_ocular_oe = $return[0]->pressao_ocular_oe;
            $this->_pressao_ocular_od = $return[0]->pressao_ocular_od;
            $this->_pressao_ocular_hora = $return[0]->pressao_ocular_hora;
            $this->_refracao_retinoscopia = $return[0]->refracao_retinoscopia;
            $this->_dinamica_estatica = $return[0]->dinamica_estatica;
            $this->_carregar_refrator = $return[0]->carregar_refrator;
            $this->_carregar_oculos = $return[0]->carregar_oculos;
            /////////////FIM OFTAMOLOGIA////////////
            $this->_idade = $return[0]->idade;
            $this->_status = $return[0]->situacao;
            $this->_agrupador_fisioterapia = $return[0]->agrupador_fisioterapia;
            $this->_procedimento = $return[0]->procedimento;
            $this->_solicitante = $return[0]->solicitante;
            $this->_nascimento = $return[0]->nascimento;
            $this->_assinatura = $return[0]->assinatura;
            $this->_rodape = $return[0]->rodape;
            $this->_cabecalho = $return[0]->cabecalho;
            $this->_quantidade = $return[0]->quantidade;
            $this->_convenio = $return[0]->convenio;
            $this->_sexo = $return[0]->sexo;
            $this->_imagens = $return[0]->imagens;
            $this->_diabetes = $return[0]->diabetes;
            $this->_hipertensao = $return[0]->hipertensao;
            $this->_cid = $return[0]->cid;
            $this->_ciddescricao = $return[0]->no_cid;
            $this->_cid2 = $return[0]->cid2;
            $this->_cid2descricao = $return[0]->no_cid2;
            $this->_peso = $return[0]->peso;
            $this->_altura = $return[0]->altura;
            $this->_pasistolica = $return[0]->pasistolica;
            $this->_padiastolica = $return[0]->padiastolica;
            if ($return[0]->peso != 0 && $return[0]->altura != 0) {
                $this->_superficie_corporea = sqrt(($return[0]->peso * $return[0]->altura) / 3600);
            } else {
                $this->_superficie_corporea = $return[0]->superficie_corporea;
            }
            $this->_ve_volume_telediastolico = $return[0]->ve_volume_telediastolico;
            $this->_ve_volume_telessistolico = $return[0]->ve_volume_telessistolico;
            $this->_ve_diametro_telediastolico = $return[0]->ve_diametro_telediastolico;
            $this->_ve_diametro_telessistolico = $return[0]->ve_diametro_telessistolico;
            $this->_ve_indice_do_diametro_diastolico = $return[0]->ve_indice_do_diametro_diastolico;
            $this->_ve_septo_interventricular = $return[0]->ve_septo_interventricular;
            $this->_ve_parede_posterior = $return[0]->ve_parede_posterior;
            $this->_ve_relacao_septo_parede_posterior = $return[0]->ve_relacao_septo_parede_posterior;
            $this->_ve_espessura_relativa_paredes = $return[0]->ve_espessura_relativa_paredes;
            $this->_ve_massa_ventricular = $return[0]->ve_massa_ventricular;
            $this->_ve_indice_massa = $return[0]->ve_indice_massa;
            $this->_ve_relacao_volume_massa = $return[0]->ve_relacao_volume_massa;
            $this->_ve_fracao_ejecao = $return[0]->ve_fracao_ejecao;
            $this->_ve_fracao_encurtamento = $return[0]->ve_fracao_encurtamento;
            $this->_vd_diametro_telediastolico = $return[0]->vd_diametro_telediastolico;
            $this->_vd_area_telediastolica = $return[0]->vd_area_telediastolica;
            $this->_vd_diametro_pel = $return[0]->vd_diametro_pel;
            $this->_vd_diametro_basal = $return[0]->vd_diametro_basal;
            $this->_ae_diametro = $return[0]->ae_diametro;
            $this->_ae_volume = $return[0]->ae_volume;
            $this->_ad_volume = $return[0]->ad_volume;
            $this->_ad_volume_indexado = $return[0]->ad_volume_indexado;
            $this->_ao_diametro_raiz = $return[0]->ao_diametro_raiz;
            $this->_ao_relacao_atrio_esquerdo_aorta = $return[0]->ao_relacao_atrio_esquerdo_aorta;
            $this->_dias_retorno = $return[0]->dias_retorno;
            $this->_medico_encaminhamento_id = $return[0]->medico_encaminhamento_id;
            $this->_convenio_id = $return[0]->convenio_id;
        } else {
            $this->_ambulatorio_laudo_id = null;
        }
    }

}

?>
