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
//        var_dump($_GET);die;
        $dataAtual = date("Y-m-d");
        $this->db->select('operador_id');
        $this->db->from('tb_operador o');
        $this->db->where('o.ativo', 't');
        $this->db->where('o.usuario', $_GET['usuario']);
//        $this->db->where('o.senha', $_GET['senha']);
        $retorno = $this->db->get()->result();
        if(count($retorno) == 0){
            return array("Erro" => "Nao foi encontrado nenhum usuario com os dados informados. "
                                 . "Por favor, certifique de ter configurado corretamente o nome de usuario e senha.");
        }
        
//        var_dump($retorno);die;
        
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
        $this->db->where('ae.medico_consulta_id', @$retorno[0]->operador_id);
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
}

?>
