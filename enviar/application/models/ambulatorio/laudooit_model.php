<?php

class laudooit_model extends Model {

    var $_ambulatorio_laudooit_id = null;
    var $_exame_id = null;
    var $_nome = null;
    var $_data_leitura = null;
    var $_medico = null;
    var $_laudo_id = null;
    var $_qualidade_tecnica = null;
    var $_comentario_1a = null;
    var $_radiografia_normal = null;
    var $_anormalidade_parenquima = null;
    var $_forma_primaria = null;
    var $_forma_secundaria = null;
    var $_zona_d = null;
    var $_zona_e = null;
    var $_profusao = null;
    var $_grandes_opacidades = null;
    var $_anormalidade_pleural = null;
    var $_placa_pleuras = null;
    var $_local_paredeperfil_3b = null;
    var $_local_frontal_3b = null;
    var $_local_diafragma_3b = null;
    var $_local_outroslocais_3b = null;
    var $_calcificacao_paredeperfil_3b = null;
    var $_calcificacao_frontal_3b = null;
    var $_calcificacao_diafragma_3b = null;
    var $_calcificacao_outroslocais_3b = null;
    var $_extensao_parede_d_3b = null;
    var $_extensao_parede_e_3b = null;
    var $_largura_d_3b = null;
    var $_largura_e_3b = null;
    var $_obliteracao = null;
    var $_espessamento_pleural_difuso = null;
    var $_local_parede_perfil_3d = null;
    var $_local_parede_frontal_3d = null;
    var $_calcificacao_parede_perfil_3d = null;
    var $_calcificacao_parede_frontal_3d = null;
    var $_extensao_parede_d_3d = null;
    var $_extensao_parede_e_3d = null;
    var $_largura_d_3d = null;
    var $_largura_e_3d = null;
    var $_outras_anormalidades = null;
    var $_simbolos = null;
    var $_comentario_4c = null;
    var $_data_cadastro = null;
    var $_operador_cadastro = null;
    var $_data_atualizacao = null;
    var $_operador_atualizacao = null;
    var $_situacao = null;
    var $_medico_parecer = null;
    var $_data = null;
    var $_data_unificacao = null;
    var $_operador_unificacao = null;
    var $_antigopaciente_id = null;

    function laudooit_model($ambulatorio_laudooit_id = null) {
        parent::Model();
        if (isset($ambulatorio_laudooit_id)) {
            $this->instanciar($ambulatorio_laudooit_id);
        }
    }

    function listar($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudooit_id,
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
        $this->db->from('tb_ambulatorio_laudooit ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = age.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->where('ag.empresa_id', $empresa_id);
//        $this->db->where('ag.tipo', 'EXAME');
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

    function listar2($args = array()) {

        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('ag.ambulatorio_laudooit_id,
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
        $this->db->from('tb_ambulatorio_laudooit ag');
        $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
        $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
        $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ag.medico_parecer1', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ag.medico_parecer2', 'left');
        $this->db->where('ag.empresa_id', $empresa_id);
//        $this->db->where('ag.tipo', 'EXAME');
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

    function gravarlaudooit($ambulatorio_laudooit_id) {
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
            $this->db->set('texto_laudooit', $_POST['laudooit']);
            $this->db->set('texto', $_POST['laudooit']);
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
            $this->db->where('ambulatorio_laudooit_id', $ambulatorio_laudooit_id);
            $this->db->update('tb_ambulatorio_laudooit');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function inserirlaudo($ambulatorio_laudo_id) {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('laudo_id', $ambulatorio_laudo_id);
            $this->db->set('qualidade_tecnica', 1);
            $this->db->set('radiografia_normal', 'on');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_laudooit');
            $ambulatorio_laudooit_id = $this->db->insert_id();
            return $ambulatorio_laudooit_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function contadorlaudo($ambulatorio_laudo_id) {

        $this->db->select('ambulatorio_laudooit_id');
        $this->db->from('tb_ambulatorio_laudooit');
        $this->db->where("laudo_id", $ambulatorio_laudo_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function consultalaudo($ambulatorio_laudo_id) {

        $this->db->select('ambulatorio_laudooit_id');
        $this->db->from('tb_ambulatorio_laudooit');
        $this->db->where("laudo_id", $ambulatorio_laudo_id);
        $query = $this->db->get();
        $return = $query->result();
        return $return;
    }

    private function instanciar($ambulatorio_laudooit_id) {

        if ($ambulatorio_laudooit_id != 0) {
            $this->db->select('al.ambulatorio_laudooit_id,
                al.laudo_id,
       al.qualidade_tecnica,
       al.comentario_1a, 
       al.radiografia_normal,
       al.anormalidade_parenquima,
       al.forma_primaria, 
       al.forma_secundaria,
       al.zona_d,
       al.zona_e,
       al.profusao,
       al.grandes_opacidades, 
       al.anormalidade_pleural,
       al.placa_pleuras,
       al.local_paredeperfil_3b,
       al.local_frontal_3b, 
       al.local_diafragma_3b,
       al.local_outroslocais_3b,
       al.calcificacao_paredeperfil_3b, 
       al.calcificacao_frontal_3b,
       al.calcificacao_diafragma_3b,
       al.calcificacao_outroslocais_3b, 
       al.extensao_parede_d_3b,
       al.extensao_parede_e_3b,
       al.largura_d_3b,
       al.largura_e_3b, 
       al.obliteracao,
       al.espessamento_pleural_difuso,
       al.local_parede_perfil_3d, 
       al.local_parede_frontal_3d,
       al.calcificacao_parede_perfil_3d,
       al.calcificacao_parede_frontal_3d, 
       al.extensao_parede_d_3d,
       al.extensao_parede_e_3d,
       al.largura_d_3d,
       al.largura_e_3d, 
       al.outras_anormalidades,
       al.simbolos,
       al.comentario_4c,
       al.data_cadastro, 
       al.operador_cadastro,
       al.data_atualizacao,
       al.operador_atualizacao,
       al.situacao, 
       al.medico_parecer,
       al.data,
       al.data_unificacao,
       al.operador_unificacao,
       al.antigopaciente_id,
       p.nome,
       ag.exame_id,
       o.nome as medico');
            $this->db->from('tb_ambulatorio_laudooit al');
            $this->db->join('tb_ambulatorio_laudo ag', 'ag.ambulatorio_laudo_id = al.laudo_id', 'left');
            $this->db->join('tb_paciente p', 'p.paciente_id = ag.paciente_id', 'left');
            $this->db->join('tb_exames ae', 'ae.exames_id = ag.exame_id', 'left');
            $this->db->join('tb_agenda_exames age', 'age.agenda_exames_id = ae.agenda_exames_id', 'left');
            $this->db->join('tb_exame_sala es', 'es.exame_sala_id = ae.sala_id', 'left');
            $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ag.procedimento_tuss_id', 'left');
            $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
            $this->db->join('tb_cid c', 'c.co_cid = ag.cid', 'left');
            $this->db->join('tb_operador o', 'o.operador_id = age.medico_solicitante', 'left');
            $this->db->where("ambulatorio_laudooit_id", $ambulatorio_laudooit_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_ambulatorio_laudooit_id = $return[0]->ambulatorio_laudooit_id;
            $this->_exame_id = $return[0]->exame_id;
            $this->_nome = $return[0]->nome;
            $this->_data_leitura = $return[0]->data;
            $this->_medico = $return[0]->medico;
            $this->_laudo_id = $return[0]->laudo_id;
            $this->_qualidade_tecnica = $return[0]->qualidade_tecnica;
            $this->_comentario_1a = $return[0]->comentario_1a;
            $this->_radiografia_normal = $return[0]->radiografia_normal;
            $this->_anormalidade_parenquima = $return[0]->anormalidade_parenquima;
            $this->_forma_primaria = $return[0]->forma_primaria;
            $this->_forma_secundaria = $return[0]->forma_secundaria;
            $this->_zona_d = $return[0]->zona_d;
            $this->_zona_e = $return[0]->zona_e;
            $this->_profusao = $return[0]->profusao;
            $this->_grandes_opacidades = $return[0]->grandes_opacidades;
            $this->_anormalidade_pleural = $return[0]->anormalidade_pleural;
            $this->_placa_pleuras = $return[0]->placa_pleuras;
            $this->_local_paredeperfil_3b = $return[0]->local_paredeperfil_3b;
            $this->_local_frontal_3b = $return[0]->local_frontal_3b;
            $this->_local_diafragma_3b = $return[0]->local_diafragma_3b;
            $this->_local_outroslocais_3b = $return[0]->local_outroslocais_3b;
            $this->_calcificacao_paredeperfil_3b = $return[0]->calcificacao_paredeperfil_3b;
            $this->_calcificacao_frontal_3b = $return[0]->calcificacao_frontal_3b;
            $this->_calcificacao_diafragma_3b = $return[0]->calcificacao_diafragma_3b;
            $this->_calcificacao_outroslocais_3b = $return[0]->calcificacao_outroslocais_3b;
            $this->_extensao_parede_d_3b = $return[0]->extensao_parede_d_3b;
            $this->_extensao_parede_e_3b = $return[0]->extensao_parede_e_3b;
            $this->_largura_d_3b = $return[0]->largura_d_3b;
            $this->_largura_e_3b = $return[0]->largura_e_3b;
            $this->_obliteracao = $return[0]->obliteracao;
            $this->_espessamento_pleural_difuso = $return[0]->espessamento_pleural_difuso;
            $this->_local_parede_perfil_3d = $return[0]->local_parede_perfil_3d;
            $this->_local_parede_frontal_3d = $return[0]->local_parede_frontal_3d;
            $this->_calcificacao_parede_perfil_3d = $return[0]->calcificacao_parede_perfil_3d;
            $this->_calcificacao_parede_frontal_3d = $return[0]->calcificacao_parede_frontal_3d;
            $this->_extensao_parede_d_3d = $return[0]->extensao_parede_d_3d;
            $this->_extensao_parede_e_3d = $return[0]->extensao_parede_e_3d;
            $this->_largura_d_3d = $return[0]->largura_d_3d;
            $this->_largura_e_3d = $return[0]->largura_e_3d;
            $this->_outras_anormalidades = $return[0]->outras_anormalidades;
            $this->_simbolos = $return[0]->simbolos;
            $this->_comentario_4c = $return[0]->comentario_4c;
            $this->_data_cadastro = $return[0]->data_cadastro;
            $this->_operador_cadastro = $return[0]->operador_cadastro;
            $this->_data_atualizacao = $return[0]->data_atualizacao;
            $this->_operador_atualizacao = $return[0]->operador_atualizacao;
            $this->_situacao = $return[0]->situacao;
            $this->_medico_parecer = $return[0]->medico_parecer;
            $this->_data = $return[0]->data;
            $this->_data_unificacao = $return[0]->data_unificacao;
            $this->_operador_unificacao = $return[0]->operador_unificacao;
            $this->_antigopaciente_id = $return[0]->antigopaciente_id;
        } else {
            $this->_ambulatorio_laudooit_id = null;
        }
    }

}

?>
