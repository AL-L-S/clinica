<?php

class login_model extends Model {
    /* Método construtor */

    function Login_model($servidor_id = null) {
        parent::Model();
    }

    function autenticar($usuario, $senha, $empresa) {
        $this->db->select(' o.operador_id,
                                o.perfil_id,
                                p.nome as perfil,
                                a.modulo_id,
                                oe.operador_empresa_id'
        );
        $this->db->from('tb_operador o');
        $this->db->join('tb_perfil p', 'p.perfil_id = o.perfil_id');
        $this->db->join('tb_acesso a', 'a.perfil_id = o.perfil_id', 'left');
        $this->db->join('tb_operador_empresas oe', 'oe.operador_id = o.operador_id', 'left');
        $this->db->where('o.usuario', $usuario);
        $this->db->where('o.senha', md5($senha));
        $this->db->where('oe.empresa_id', $empresa);
        $this->db->where('oe.ativo = true');
        $this->db->where('o.ativo = true');
        $this->db->where('p.ativo = true');
        $return = $this->db->get()->result();

        $this->db->select('empresa_id,
                            nome,
                            internacao,
                            centrocirurgico,
                            relatoriorm,
                            chat,
                               servicosms,
                               servicoemail');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa);
        $retorno = $this->db->get()->result();

        if (count($retorno) > 0) {
            $servicosms = $retorno[0]->servicosms;
            $servicoemail = $retorno[0]->servicoemail;
            $empresanome = $retorno[0]->nome;
            $internacao = $retorno[0]->internacao;
            $chat = $retorno[0]->chat;
            $centrocirurgico = $retorno[0]->centrocirurgico;
            $relatoriorm = $retorno[0]->relatoriorm;
        } else {
            $empresanome = "";
            $internacao = false;
        }

        if (isset($return) && count($return) > 0) {

            //marcando o usuario como 'online'
            $horario = date("Y-m-d H:i:s");
            $this->db->set('horario_login', $horario);
            $this->db->set('online', 't');
            $this->db->where('operador_id', $return[0]->operador_id);
            $this->db->update('tb_operador');

            $modulo[] = null;
            foreach ($return as $value) {
                if (isset($value->modulo_id)) {
                    $modulo[] = $value->modulo_id;
                }
            }
            $p = array(
                'autenticado' => true,
                'operador_id' => $return[0]->operador_id,
                'login' => $usuario,
                'perfil_id' => $return[0]->perfil_id,
                'perfil' => $return[0]->perfil,
                'modulo' => $modulo,
                'centrocirurgico' => $centrocirurgico,
                'relatoriorm' => $relatoriorm,
                'internacao' => $internacao,
                'chat' => $chat,
                'servicosms' => $servicosms,
                'servicoemail' => $servicoemail,
                "verificandoMensagens" => false,
                'empresa_id' => $empresa,
                'empresa' => $empresanome
            );
            $this->session->set_userdata($p);
            return true;
        } else {
            $this->session->sess_destroy();
            return false;
        }
    }

    function atualizandoatendidostabelasms($exames, $disponivel) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('mensagem_agradecimento');
        $this->db->from('tb_empresa_sms');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $retorno = $this->db->get()->result();
        $mensagem = @$retorno[0]->mensagem_agradecimento;

        $horario = date('Y-m-d');
        $i = 1;
        foreach ($exames as $item) {
            if ($i <= $disponivel) {

                $this->db->set('agenda_exames_id', $item->agenda_exames_id);
                $this->db->set('paciente_id', $item->paciente_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('numero', preg_replace('/[^\d]+/', '', $item->celular));
                $this->db->set('mensagem', $mensagem);
                $this->db->set('tipo', 'AGRADECIMENTO');
                $this->db->set('data', $horario);
                $this->db->insert('tb_sms');

                $i++;
            } else {
                break;
            }
        }
        return $i;
    }

    function atualizandoagendadostabelasms($exames, $disponivel) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('mensagem_confirmacao');
        $this->db->from('tb_empresa_sms');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $retorno = $this->db->get()->result();
        $mensagem = @$retorno[0]->mensagem_confirmacao;

        $horario = date('Y-m-d');
        $i = 1;
        foreach ($exames as $item) {
            if ($i <= $disponivel) {

                $this->db->set('agenda_exames_id', $item->agenda_exames_id);
                $this->db->set('paciente_id', $item->paciente_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('numero', preg_replace('/[^\d]+/', '', $item->celular));
                $this->db->set('mensagem', $mensagem . " Consulta: " . $item->nome);
                $this->db->set('tipo', 'CONFIRMACAO');
                $this->db->set('data', $horario);
                $this->db->insert('tb_sms');

                $i++;
            } else {
                break;
            }
        }
        return $i;
    }

    function revisoes() {
        $horario = date("Y-m-d");

        $this->db->select('ae.agenda_exames_id,
                           p.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           pt.nome,
                           pt.revisao_dias');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.realizada', 'f');
        $this->db->where("(p.celular IS NOT NULL AND p.celular != '')");
        $this->db->where("pt.procedimento_tuss_id IN (
                            SELECT procedimento_tuss_id FROM ponto.tb_procedimento_tuss
                            WHERE revisao = 't'
                          )
                          AND (ae.data + pt.revisao_dias) =  '{$horario}'");
        $return = $this->db->get();
        return $return->result();
    }

    function atualizandorevisoestabelasms($revisoes, $disponivel) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('mensagem_revisao');
        $this->db->from('tb_empresa_sms');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $retorno = $this->db->get()->result();
        $mensagem = @$retorno[0]->mensagem_revisao;

        $horario = date('Y-m-d');
        $i = 1;
        foreach ($revisoes as $item) {
            if ($i <= $disponivel) {
                $msg = $mensagem . " Procedimento: " . $item->nome;
                $this->db->set('paciente_id', $item->paciente_id);
                $this->db->set('numero', preg_replace('/[^\d]+/', '', $item->celular));
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('mensagem', $msg);
                $this->db->set('tipo', 'REVISAO');
                $this->db->set('data', $horario);
                $this->db->insert('tb_sms');

                $i++;
            } else {
                break;
            }
        }
        return $i;
    }

    function atualizandoaniversariantestabelasms($aniversariantes, $disponivel) {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('mensagem_aniversariante');
        $this->db->from('tb_empresa_sms');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $retorno = $this->db->get()->result();
        $mensagem = @$retorno[0]->mensagem_aniversariante;

        $horario = date('Y-m-d');
        $i = 1;
        foreach ($aniversariantes as $item) {
            if ($i <= $disponivel) {
                $this->db->set('paciente_id', $item->paciente_id);
                $this->db->set('numero', preg_replace('/[^\d]+/', '', $item->celular));
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('mensagem', $mensagem);
                $this->db->set('tipo', 'ANIVERSARIANTE');
                $this->db->set('data', $horario);
                $this->db->insert('tb_sms');

                $i++;
            } else {
                break;
            }
        }
        return $i;
    }

    function atualizandoregistro() {
        $empresa_id = $this->session->userdata('empresa_id');

        $horario = date('Y-m-d');
        $this->db->select('COUNT(*) as total');
        $this->db->from('tb_sms');
        $this->db->where('registrado', 'f');
        $this->db->where('data', $horario);
        $this->db->where('empresa_id', $empresa_id);
        $retorno = $this->db->get()->result();

        $periodo = date('m/Y');
        $total = ($retorno[0]->total != "") ? $retorno[0]->total : 0;
        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('periodo', $periodo);
        $this->db->set('qtde', $total);
        $this->db->where('data_verificacao', $horario);
        $this->db->update('tb_empresa_sms_registro');

        $this->db->set('registrado', 't');
        $this->db->where('data', $horario);
        $this->db->update('tb_sms');
    }

    function listarempresapacote() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('quantidade');
        $this->db->from('tb_empresa_sms es');
        $this->db->join('tb_pacote_sms ps', 'ps.pacote_sms_id = es.pacote_id', 'left');
        $this->db->where('empresa_id', $empresa_id);
        $return = $this->db->get()->result();
        return (@$return[0]->quantidade != '') ? @$return[0]->quantidade : 0;
    }

    function listarsms() {
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('s.sms_id, s.numero, s.mensagem, controle_id, e.razao_social, e.cnpj, s.agenda_exames_id, s.paciente_id');
        $this->db->from('tb_sms s');
        $this->db->join('tb_empresa e', 'e.empresa_id = s.empresa_id');
        $this->db->where('e.razao_social IS NOT NULL');
        $this->db->where('e.cnpj IS NOT NULL');
        $this->db->where('s.enviado', 'f');
        $this->db->where('s.ativo', 't');
        $this->db->where('s.empresa_id', $empresa_id);
        $return = $this->db->get()->result_array();

        $this->db->set('enviado', 't');
        $this->db->where('enviado', 'f');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->update('tb_sms');

        return $return;
    }

    function atualizandonumerocontrole($resultado) {
        foreach ($resultado as $item) {
            $this->db->set('controle_id', $item["controle_id"]);
            $this->db->where('sms_id', $item["sms_id"]);
            $this->db->update('tb_sms');
        }
    }

    function totalutilizado() {
        $periodo = date('m/Y');
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('sum(qtde) as total');
        $this->db->from('tb_empresa_sms_registro');
        $this->db->where('periodo', $periodo);
        $this->db->where('empresa_id', $empresa_id);
        $this->db->groupby('empresa_id, periodo');
        $return = $this->db->get()->result();
        return (@$return[0]->total != '') ? @$return[0]->total : '';
    }

    function aniversariantes() {
        $dia = date('d');
        $mes = date('m');
        $this->db->select('p.paciente_id,
                           p.nome as paciente,
                           p.celular');
        $this->db->from('tb_paciente p');
        $this->db->where('p.ativo', 't');
        $this->db->where("(p.celular IS NOT NULL AND p.celular != '')");
        $this->db->where("EXTRACT(DAY FROM p.nascimento) = $dia AND EXTRACT(MONTH FROM p.nascimento) = $mes");
        $return = $this->db->get();
        return $return->result();
    }

    function atendimentos() {
        $horario = date('d-m-Y');
        $this->db->select('ae.agenda_exames_id,
                           p.paciente_id,
                           p.nome as paciente,
                           p.celular');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.realizada', 't');
        $this->db->where("(p.celular IS NOT NULL AND p.celular != '')");
        $this->db->where('ae.data', $horario);
        $return = $this->db->get();
        return $return->result();
    }

    function examesagendados() {
        $d = (date('N') == 6) ? 2 : 1;
        $diaSeguinte = date('d-m-Y', strtotime("+$d day", strtotime(date('d-m-Y'))));
        $this->db->select('ae.agenda_exames_id,
                           p.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           pt.nome');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.realizada', 'f');
        $this->db->where("(p.celular IS NOT NULL AND p.celular != '')");
        $this->db->where('ae.data', $diaSeguinte);
//        $this->db->limit(50);
        $return = $this->db->get();
        return $return->result();
    }

    function emailautomatico() {


        $horario = date('Y-m-d');
        $this->db->set('data_verificacao', $horario);
        $this->db->insert('tb_empresa_sms_registro');

        $this->db->select('ae.paciente_id,
                           p.nome as paciente,
                           ae.data,
                           p.cns');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where("ae.data", $horario);
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.realizada', 'f');
        $this->db->where("(p.cns IS NOT NULL AND p.cns != '')");
        $return = $this->db->get()->result();



        $this->db->select('p.nome as paciente,
                           ae.data_revisao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where(" ae.data_revisao", ( date('Y-m-d', strtotime("+15 days", strototime(date('Y-m-d'))))));
        $this->db->where("(ae.data_revisao IS NOT NULL AND ae.data_revisao != '')");
        $revisoes = $this->db->get()->result();



        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('email, razao_social, email_mensagem_confirmacao');
        $this->db->from('tb_empresa');
        $this->db->where("empresa_id", $empresa_id);
        $dadosEmpresa = $this->db->get()->result();

        if ($dadosEmpresa[0]->email != '') {
            $this->load->library('email');
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.gmail.com';
            $config['smtp_port'] = '465';
            $config['smtp_user'] = 'stgsaude@gmail.com';
            $config['smtp_pass'] = 'saude123';
            $config['validate'] = TRUE;
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";

            foreach ($return as $value) {
                $this->email->initialize($config);
                $this->email->from($dadosEmpresa[0]->email, $dadosEmpresa[0]->razao_social);
                $this->email->to($value->cns);
                $this->email->subject("Lembrete de Consulta");
                $this->email->message($dadosEmpresa[0]->email_mensagem_confirmacao);
                $this->email->send();
            }

            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.gmail.com';
            $config['smtp_port'] = '465';
            $config['smtp_user'] = 'stgsaude@gmail.com';
            $config['smtp_pass'] = 'saude123';
            $config['validate'] = TRUE;
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";

            foreach ($revisoes as $item) {
                $this->email->initialize($config);
                $this->email->from($dadosEmpresa[0]->email, "SISTEMA STG");
                $this->email->to($dadosEmpresa[0]->email);
                $this->email->subject("Revisao");
                $msg = "O paciente: " . $item->paciente . " tem uma revisão marcada para a data " . date("d/m/Y", strtotime($item->data_revisao));
                $this->email->message($msg);
                $this->email->send();
            }
        }
    }

    function verificaemail() {
        $horario = date("Y-m-d");
        $this->db->select('data_verificacao');
        $this->db->from('tb_empresa_email_verificacao');
        $this->db->where('data_verificacao', $horario);
        $return = $this->db->get();
        return $return->result();
    }

    function verificasms() {
        $horario = date("Y-m-d");
        $this->db->select('data_verificacao');
        $this->db->from('tb_empresa_sms_registro');
        $this->db->where('data_verificacao', $horario);
        $return = $this->db->get();
        return $return->result();
    }

    function listar() {

        $this->db->select('empresa_id,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->orderby('empresa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function sair() {
        $operador_id = $this->session->userdata('operador_id');
        $horario = date(" Y-m-d H:i:s");

        $this->db->set('horario_logout', $horario);
        $this->db->where('operador_id', $operador_id);
        $this->db->update('tb_operador');
    }

}

?>
