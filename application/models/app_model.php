<?php

class app_model extends Model {

    function App_model($ambulatorio_pacientetemp_id = null) {
        parent::Model();
//        $this->load->library('utilitario');
    }

    function buscarAtendimentosMarcados() {
        $this->db->select('operador_id');
        $this->db->from('tb_operador');
        $this->db->where('usuario', $_GET['usuario']);
        $this->db->where('senha', md5($_GET['pw']));
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function listarLembretes() {
        
        $operador_id = $_GET['operador_id'];

        $this->db->select(" el.empresa_lembretes_id,
                            el.texto,
                            el.data_cadastro,
                            o.nome as operador,
                            op.nome as remetente,
                            (
                                SELECT COUNT(*) 
                                FROM ponto.tb_empresa_lembretes_visualizacao 
                                WHERE ponto.tb_empresa_lembretes_visualizacao.empresa_lembretes_id = el.empresa_lembretes_id 
                            ) as visualizado");
        $this->db->from('tb_empresa_lembretes el');
        $this->db->join('tb_operador o', "o.operador_id = el.operador_destino");
        $this->db->join('tb_operador op', "op.operador_id = el.operador_cadastro");
        $this->db->where('el.ativo', 't');
        $this->db->where('operador_destino', $operador_id);
        $this->db->orderby('data_cadastro DESC');
        $return = $this->db->get();
        return $return->result();
    }

    function buscarLembreteNaoLido() {
        
        $operador_id = $_GET['operador_id'];
//        var_dump($operador_id); die;
        $this->db->select('empresa_lembretes_id,
                            texto,
                            empresa_id,
                            o.nome as operador');
        $this->db->from('tb_empresa_lembretes el');
        $this->db->join('tb_operador o', 'o.operador_id = el.operador_cadastro', 'left');
        $this->db->where('el.ativo', 't');
        $this->db->where('operador_destino', $operador_id);
        $this->db->where('(
                            SELECT COUNT(*) 
                            FROM ponto.tb_empresa_lembretes_visualizacao 
                            WHERE ponto.tb_empresa_lembretes_visualizacao.empresa_lembretes_id = el.empresa_lembretes_id 
                            AND ponto.tb_empresa_lembretes_visualizacao.operador_visualizacao = ' . $operador_id . '
                        ) =', 0);
        $return = $this->db->get();
        $retorno = $return->result();
        
        foreach($retorno as $value){
            
            $empresa_id = $value->empresa_id;
            $horario = date("Y-m-d H:i:s");

            $this->db->set('empresa_lembretes_id', $value->empresa_lembretes_id);
            $this->db->set('data_visualizacao', $horario);
            $this->db->set('operador_visualizacao', $operador_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->insert('tb_empresa_lembretes_visualizacao');
            
        }
        
        return $retorno;
    }

    function validaUsuario() {
        $this->db->select('operador_id');
        $this->db->from('tb_operador');
        $this->db->where('usuario', $_GET['usuario']);
        $this->db->where('senha', md5($_GET['pw']));
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        $return = $this->db->get();
        return $return->result();
    }

    function buscandoAgenda() {
        ini_set('display_errors',1);
        ini_set('display_startup_erros',1);
        error_reporting(E_ALL);
                
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
                            ae.nome,
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
        $this->db->join('tb_convenio co', 'co.convenio_id = p.convenio_id', 'left');
        $this->db->join('tb_exame_sala an', 'an.exame_sala_id = ae.agenda_exames_nome_id', 'left');
        $this->db->join('tb_exames e', 'e.agenda_exames_id= ae.agenda_exames_id', 'left');
        $this->db->join('tb_ambulatorio_laudo al', 'al.exame_id = e.exames_id', 'left');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->join('tb_ambulatorio_tipo_consulta tc', 'tc.ambulatorio_tipo_consulta_id = ae.tipo_consulta_id', 'left');
        $this->db->join('tb_operador op', 'op.operador_id = ae.operador_atualizacao', 'left');
        $this->db->join('tb_operador tel', 'tel.operador_id = ae.operador_telefonema', 'left');
//        $this->db->where('ae.data', $dataAtual);
        $this->db->where('ae.cancelada', 'false');
        $this->db->where('ae.medico_consulta_id', $_GET['operador_id']);
        if (@$_GET['situacao'] != '') {
            switch ($_GET['situacao']) {
                case 'o':
                    $situacao = 'OK';
                    break;
                case 'v':
                    $situacao = 'LIVRE';
                    break;
                case 'b':
                    $situacao = 'BLOQUEADO';
                    break;
                case 'f':
                    $situacao = 'FALTOU';
                    break;
                default:
                    break;
            }
            if (isset($situacao)) {
                if ($situacao == "BLOQUEADO") {
                    $this->db->where('ae.bloqueado', 't');
                }
                if ($situacao == "LIVRE") {
                    $this->db->where('ae.bloqueado', 'f');
                    $this->db->where('ae.situacao', 'LIVRE');
                }
                if ($situacao == "OK") {
                    $this->db->where('ae.situacao', 'OK');
                }
                if ($situacao == "FALTOU") {
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

        if(@$_GET['data'] != ""){
            $this->db->where('ae.data', date("Y-m-d", strtotime($_GET['data'])) );
        }
        else{
            $this->db->where('ae.data', date("Y-m-d"));
        }
        
        if(@$_GET['paciente'] != ""){
            $this->db->where('p.nome ilike', "%" . $_GET['paciente'] . "%");
        }
        
        $this->db->orderby('ae.agenda_exames_id');
        $this->db->orderby('ae.data');
        $this->db->orderby('ae.inicio');
        $this->db->orderby('al.situacao LIMIT 15 OFFSET ('. ((@$_GET['pagina'] != '') ? $_GET['pagina'] : 0).') * 15 ');
//        $_GET['pagina'] = (@$_GET['pagina'] != '') ? $_GET['pagina'] : 0);
//        $this->db->limit("");
        
        $return = $this->db->get();
        return $return->result();
    }
    
    function buscarQuantidadeAtendimentos($operador_id) {
                
        $this->db->select('ae.telefonema, 
                           o.nome as medico,
                           ae.inicio');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_operador o', 'o.operador_id = ae.medico_consulta_id', 'left');
        $this->db->where('ae.paciente_id IS NOT NULL');
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.data', date("Y-m-d", strtotime("+1 day")) );
        $this->db->where('ae.medico_consulta_id', $operador_id);
        $this->db->orderby('ae.inicio');
        
        $return = $this->db->get();
        
        return $return->result();
    }
    
    function confirmarAtendimento(){
        $operador_id = $_GET['operador_id'];
        $resposta = $_GET['value'];
        $data = date("Y-m-d", strtotime("+1 day"));
        
        $this->db->set("confirmacao_medico", $resposta);
        $this->db->where("data", $data);
        $this->db->where("medico_consulta_id", $operador_id);
        $this->db->update("tb_agenda_exames");
        
    }
}

?>
