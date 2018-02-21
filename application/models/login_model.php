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

        $this->db->select('e.*, 
                           ep.procedimento_excecao, 
                           ep.calendario_layout, 
                           ep.recomendacao_configuravel, 
                           ep.recomendacao_obrigatorio, 
                           ep.valor_autorizar,
                           ep.gerente_contasapagar,
                           ep.cpf_obrigatorio,
                           ep.orcamento_recepcao,
                           ep.relatorio_ordem,
                           ep.relatorio_producao,
                           ep.relatorios_recepcao,
                           ep.laudo_sigiloso,
                           ep.financeiro_cadastro,       
                           ep.caixa_personalizado,       
                           ep.botao_ativar_sala');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id');
//        
        $this->db->where('e.empresa_id', $empresa);
        $retorno = $this->db->get()->result();

        if (count($retorno) > 0) {
            $servicosms = $retorno[0]->servicosms;
            $servicoemail = $retorno[0]->servicoemail;
            $empresanome = $retorno[0]->nome;
            $internacao = $retorno[0]->internacao;
            $laudo_sigiloso = $retorno[0]->laudo_sigiloso;
            $chat = $retorno[0]->chat;
            $centrocirurgico = $retorno[0]->centrocirurgico;
            $relatoriorm = $retorno[0]->relatoriorm;
            $imagem = $retorno[0]->imagem;
            $consulta = $retorno[0]->consulta;
            $especialidade = $retorno[0]->especialidade;
            $odontologia = $retorno[0]->odontologia;
            $geral = $retorno[0]->geral;
            $faturamento = $retorno[0]->faturamento;
            $estoque = $retorno[0]->estoque;
            $financeiro = $retorno[0]->financeiro;
            $marketing = $retorno[0]->marketing;
            $laboratorio = $retorno[0]->laboratorio;
            $ponto = $retorno[0]->ponto;
            $calendario = $retorno[0]->calendario;
            $procedimento_multiempresa = $retorno[0]->procedimento_multiempresa;
            $botao_faturar_guia = $retorno[0]->botao_faturar_guia;
            $botao_faturar_proc = $retorno[0]->botao_faturar_procedimento;
            $producao_medica_saida = $retorno[0]->producao_medica_saida;
            $procedimento_excecao = $retorno[0]->procedimento_excecao;
            $calendario_layout = $retorno[0]->calendario_layout;
            $recomendacao_configuravel = $retorno[0]->recomendacao_configuravel;
            $recomendacao_obrigatorio = $retorno[0]->recomendacao_obrigatorio;
            $botao_ativar_sala = $retorno[0]->botao_ativar_sala;


            $gerente_contasapagar = $retorno[0]->gerente_contasapagar;
            $orcamento_recepcao = $retorno[0]->orcamento_recepcao;
            $relatorio_ordem = $retorno[0]->relatorio_ordem;
            $relatorio_producao = $retorno[0]->relatorio_producao;
            $relatorios_recepcao = $retorno[0]->relatorios_recepcao;
            $financeiro_cadastro = $retorno[0]->financeiro_cadastro;
            $logo_clinica = $retorno[0]->mostrar_logo_clinica;
            $caixa_personalizado = $retorno[0]->caixa_personalizado;
        } else {
            $empresanome = "";
            $internacao = false;
        }
//        var_dump($gerente_contasapagar); die;
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
                'laudo_sigiloso' => $laudo_sigiloso,
                'centrocirurgico' => $centrocirurgico,
                'gerente_contasapagar' => $gerente_contasapagar,
                'orcamento_recepcao' => $orcamento_recepcao,
                'relatorio_ordem' => $relatorio_ordem,
                'relatorio_producao' => $relatorio_producao,
                'relatorios_recepcao' => $relatorios_recepcao,
                'financeiro_cadastro' => $financeiro_cadastro,
                'relatoriorm' => $relatoriorm,
                'imagem' => $imagem,
                'consulta' => $consulta,
                'especialidade' => $especialidade,
                'odontologia' => $odontologia,
                'geral' => $geral,
                'faturamento' => $faturamento,
                'estoque' => $estoque,
                'financeiro' => $financeiro,
                'marketing' => $marketing,
                'laboratorio' => $laboratorio,
                'ponto' => $ponto,
                'calendario' => $calendario,
                'internacao' => $internacao,
                'chat' => $chat,
                'servicosms' => $servicosms,
                'servicoemail' => $servicoemail,
                "verificandoMensagens" => false,
                'botao_faturar_guia' => $botao_faturar_guia,
                'botao_faturar_proc' => $botao_faturar_proc,
                'empresa_id' => $empresa,
                'procedimento_multiempresa' => $procedimento_multiempresa,
                'producao_medica_saida' => $producao_medica_saida,
                'procedimento_excecao' => $procedimento_excecao,
                'calendario_layout' => $calendario_layout,
                'recomendacao_configuravel' => $recomendacao_configuravel,
                'recomendacao_obrigatorio' => $recomendacao_obrigatorio,
                'caixa_personalizado' => $caixa_personalizado,
                'botao_ativar_sala' => $botao_ativar_sala,
                'logo_clinica' => $logo_clinica,
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
                $this->db->set('sms_enviado', 't');
                $this->db->where('agenda_exames_id', $item->agenda_exames_id);
                $this->db->update('tb_agenda_exames');

                $this->db->set('agenda_exames_id', $item->agenda_exames_id);
                $this->db->set('paciente_id', $item->paciente_id);
                $this->db->set('empresa_id', $empresa_id);

                $numero = ($item->celular != '') ? $item->celular : $item->telefone;

                $this->db->set('numero', preg_replace('/[^\d]+/', '', $numero));
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
//
                $this->db->set('sms_enviado', 't');
                $this->db->where('agenda_exames_id', $item->agenda_exames_id);
                $this->db->update('tb_agenda_exames');

                $numero = ($item->celular != '') ? $item->celular : $item->telefone;

                $this->db->set('agenda_exames_id', $item->agenda_exames_id);
                $this->db->set('paciente_id', $item->paciente_id);
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('numero', preg_replace('/[^\d]+/', '', $numero));
                $this->db->set('mensagem', str_replace("_dia_", date("d/m/Y", strtotime($item->data)), $mensagem));
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
                           pt.revisao_dias,
                           p.telefone');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.realizada', 'f');
        $this->db->where("((p.celular IS NOT NULL AND p.celular != '') OR (p.telefone IS NOT NULL AND p.telefone != ''))");
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
                $numero = ($item->celular != '') ? $item->celular : $item->telefone;
                $this->db->set('numero', preg_replace('/[^\d]+/', '', $numero));
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

    function listarempresasmsdados() {
        $empresa_id = $this->session->userdata('empresa_id');

        $this->db->select('ip_servidor_sms, enviar_excedentes, numero_indentificacao_sms');
        $this->db->from('tb_empresa_sms');
        $this->db->where('empresa_id', $empresa_id);
        $this->db->where('ativo', 't');
        $retorno = $this->db->get()->result();
        return $retorno;
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
                            ep.valor_autorizar,
                            ep.gerente_contasapagar,
                            ep.cpf_obrigatorio,
                            ep.orcamento_recepcao,
                            ep.relatorio_ordem,
                            ep.relatorio_producao,
                            ep.relatorios_recepcao,
                            ep.financeiro_cadastro,                            
                            cabecalho_config,
                            valor_recibo_guia,
                            odontologia_valor_alterar,
                            selecionar_retorno,
                            oftamologia,
                            ');
        $this->db->from('tb_empresa e');
        $this->db->where('e.empresa_id', $empresa_id);
        $this->db->join('tb_empresa_permissoes ep', 'ep.empresa_id = e.empresa_id', 'left');
        $this->db->orderby('e.empresa_id');
        $return = $this->db->get();
        return $return->result();
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
                $numero = ($item->celular != '') ? $item->celular : $item->telefone;
                $this->db->set('numero', preg_replace('/[^\d]+/', '', $numero));
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

    function verificacaosmsdia() {
        $empresa_id = $this->session->userdata('empresa_id');

        $horario = date('Y-m-d');

        $this->db->select('COUNT(*) as total');
        $this->db->from('tb_empresa_sms_registro');
        $this->db->where('data_verificacao', $horario);
        $this->db->where('empresa_id', $empresa_id);
        $retorno = $this->db->get()->result();
        return $retorno;
    }

    function confirmarAtendimentoSMS($agenda_exames_id) {

        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('telefonema', 't');
        $this->db->set('data_telefonema', $horario);
        $this->db->set('operador_telefonema', $operador_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');

        $this->db->select('ae.inicio, pt.nome as procedimento, ae.data, p.nome as paciente');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where('ae.agenda_exames_id', $agenda_exames_id);
        $retorno = $this->db->get()->result();
        return $retorno;
    }

    function criandoregistrosms() {
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date('Y-m-d');
        $periodo = date('m/Y');

        $this->db->set('empresa_id', $empresa_id);
        $this->db->set('periodo', $periodo);
        $this->db->set('data_verificacao', $horario);
        $this->db->insert('tb_empresa_sms_registro');
        $registro_sms = $this->db->insert_id();
        return $registro_sms;
    }

    function atualizandoregistro($registro_sms_id) {
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
        $this->db->set('data_verificacao', $horario);
        $this->db->where('empresa_sms_registro_id', $registro_sms_id);
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
        $this->db->select("s.sms_id, 
                           s.numero, 
                           s.mensagem, 
                           s.agenda_exames_id, 
                           controle_id, 
                           numero_indentificacao_sms as numero_indentificacao, 
                           s.tipo, 
                           es.endereco_externo,
                           es.remetente_sms");
        $this->db->from('tb_sms s');
        $this->db->join('tb_empresa e', 'e.empresa_id = s.empresa_id');
        $this->db->join('tb_empresa_sms es', 'es.empresa_id = s.empresa_id');
//        $this->db->where('e.razao_social IS NOT NULL');
//        $this->db->where('e.cnpj IS NOT NULL');
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
            $sql = "UPDATE ponto.tb_sms SET controle_id={$item["controle_id"]} WHERE sms_id={$item["sms_id"]}";
            $this->db->query($sql);
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
                           p.celular,
                           p.telefone');
        $this->db->from('tb_paciente p');
        $this->db->where('p.ativo', 't');
        $this->db->where("((p.celular IS NOT NULL AND p.celular != '') OR (p.telefone IS NOT NULL AND p.telefone != ''))");
        $this->db->where("EXTRACT(DAY FROM p.nascimento) = $dia AND EXTRACT(MONTH FROM p.nascimento) = $mes");
        $return = $this->db->get();
        return $return->result();
    }

    function atendimentos() {
        $horario = date('d-m-Y');
        $this->db->select('ae.agenda_exames_id,
                           p.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           p.telefone');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.sms_enviado', 'f');
        $this->db->where('ae.realizada', 't');
        $this->db->where("((p.celular IS NOT NULL AND p.celular != '') OR (p.telefone IS NOT NULL AND p.telefone != ''))");
        $this->db->where('ae.data', $horario);
        $return = $this->db->get();
        return $return->result();
    }

    function examesagendados() {
        $d = (date('N') == 6) ? 2 : 1;
        $diaSeguinte = date('d-m-Y', strtotime("+$d day", strtotime(date('d-m-Y'))));
        $this->db->select('ae.agenda_exames_id,
                           ae.data,
                           p.paciente_id,
                           p.nome as paciente,
                           p.celular,
                           p.telefone,
                           pt.nome');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ae.procedimento_tuss_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.sms_enviado', 'f');
        $this->db->where('ae.realizada', 'f');
        $this->db->where("((p.celular IS NOT NULL AND p.celular != '') OR (p.telefone IS NOT NULL AND p.telefone != ''))");
        $this->db->where('ae.data', $diaSeguinte);
//        $this->db->limit(50);
        $return = $this->db->get();
        return $return->result();
    }

    function emailautomatico() {
        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date('Y-m-d');
        $this->db->set('data_verificacao', $horario);
        $this->db->set('empresa_id', $empresa_id);
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

        $this->db->select('ae.paciente_id,
                           p.nome as paciente,
                           ae.data,
                           p.cns');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        date_default_timezone_set('America/Fortaleza');

        $totime = strtotime("-1 days");
        $data_atual = date('Y-m-d', $totime);

        $this->db->where('ae.cancelada', 'f');
        $this->db->where('ae.realizada', 'f');
        $this->db->where("(p.cns IS NOT NULL AND p.cns != '')");
        $this->db->where('ae.data', $data_atual);
        $this->db->where('ae.situacao', 'OK');
        $this->db->where('ae.realizada', 'f');
        $this->db->where('ae.bloqueado', 'f');
        $this->db->where('ae.operador_atualizacao is not null');
        $faltas = $this->db->get()->result();

        $this->db->select('p.nome as paciente,
                           ae.data_revisao');
        $this->db->from('tb_agenda_exames ae');
        $this->db->join('tb_paciente p', 'p.paciente_id = ae.paciente_id', 'left');
        $this->db->where("ae.data_revisao =", ( date('Y-m-d', strtotime("+15 days", strtotime(date('Y-m-d'))))));
        $this->db->where("(ae.data_revisao IS NOT NULL)");
        $revisoes = $this->db->get()->result();



        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('email, razao_social, email_mensagem_confirmacao, email_mensagem_falta');
        $this->db->from('tb_empresa');
        $this->db->where("empresa_id", $empresa_id);
        $dadosEmpresa = $this->db->get()->result();

        if ($dadosEmpresa[0]->email != '') {

            $this->load->library('My_phpmailer');
            $mail = new PHPMailer(true);

            foreach ($return as $value) {
                $mail->setLanguage('br');                             // Habilita as saídas de erro em Português
                $mail->CharSet = 'UTF-8';                             // Habilita o envio do email como 'UTF-8'
                $mail->SMTPDebug = 3;                               // Habilita a saída do tipo "verbose"
                $mail->isSMTP();                                      // Configura o disparo como SMTP
                $mail->Host = 'smtp.gmail.com';                       // Especifica o enderço do servidor SMTP da Locaweb
                $mail->SMTPAuth = true;                               // Habilita a autenticação SMTP
                $mail->Username = 'stgsaude@gmail.com';                    // Usuário do SMTP
                $mail->Password = 'saude123';                   // Senha do SMTP
                $mail->SMTPSecure = 'ssl';                            // Habilita criptografia TLS | 'ssl' também é possível
                $mail->Port = 465;                                    // Porta TCP para a conexão
                $mail->From = $dadosEmpresa[0]->email;             // Endereço previamente verificado no painel do SMTP
                $mail->FromName = $dadosEmpresa[0]->razao_social;                        // Nome no remetente
                $mail->addAddress($value->cns);                            // Acrescente um destinatário
                $mail->isHTML(true);                                  // Configura o formato do email como HTML
                $mail->Subject = "Lembrete de Consulta";
                $mail->Body = $dadosEmpresa[0]->email_mensagem_confirmacao;

//                $mail->AddAttachment("./upload/nfe/$solicitacao_cliente_id/validada/" . $notafiscal[0]->chave_nfe . '-danfe.pdf', $notafiscal[0]->chave_nfe . '-danfe.pdf');

                if (!$mail->Send()) {
                    $mensagem = "Erro: " . $mail->ErrorInfo;
                } else {
                    $mensagem = "Email enviado com sucesso!";
                }
            }

            foreach ($faltas as $value) {
                $mail->setLanguage('br');                             // Habilita as saídas de erro em Português
                $mail->CharSet = 'UTF-8';                             // Habilita o envio do email como 'UTF-8'
                $mail->SMTPDebug = 3;                               // Habilita a saída do tipo "verbose"
                $mail->isSMTP();                                      // Configura o disparo como SMTP
                $mail->Host = 'smtp.gmail.com';                       // Especifica o enderço do servidor SMTP da Locaweb
                $mail->SMTPAuth = true;                               // Habilita a autenticação SMTP
                $mail->Username = 'stgsaude@gmail.com';                    // Usuário do SMTP
                $mail->Password = 'saude123';                   // Senha do SMTP
                $mail->SMTPSecure = 'ssl';                            // Habilita criptografia TLS | 'ssl' também é possível
                $mail->Port = 465;                                    // Porta TCP para a conexão
                $mail->From = $dadosEmpresa[0]->email;             // Endereço previamente verificado no painel do SMTP
                $mail->FromName = $dadosEmpresa[0]->razao_social;                        // Nome no remetente
                $mail->addAddress($value->cns);                            // Acrescente um destinatário
                $mail->isHTML(true);                                  // Configura o formato do email como HTML
                $mail->Subject = "";
                $mail->Body = $dadosEmpresa[0]->email_mensagem_falta;

                if (!$mail->Send()) {
                    $mensagem = "Erro: " . $mail->ErrorInfo;
                } else {
                    $mensagem = "Email enviado com sucesso!";
                }
            }

            foreach ($revisoes as $item) {
                $msg = "O paciente: " . $item->paciente . " tem uma revisão marcada para a data " . date("d/m/Y", strtotime($item->data_revisao));
                $mail->setLanguage('br');                             // Habilita as saídas de erro em Português
                $mail->CharSet = 'UTF-8';                             // Habilita o envio do email como 'UTF-8'
                $mail->SMTPDebug = 3;                               // Habilita a saída do tipo "verbose"
                $mail->isSMTP();                                      // Configura o disparo como SMTP
                $mail->Host = 'smtp.gmail.com';                       // Especifica o enderço do servidor SMTP da Locaweb
                $mail->SMTPAuth = true;                               // Habilita a autenticação SMTP
                $mail->Username = 'stgsaude@gmail.com';                    // Usuário do SMTP
                $mail->Password = 'saude123';                   // Senha do SMTP
                $mail->SMTPSecure = 'ssl';                            // Habilita criptografia TLS | 'ssl' também é possível
                $mail->Port = 465;                                    // Porta TCP para a conexão
                $mail->From = $dadosEmpresa[0]->email;             // Endereço previamente verificado no painel do SMTP
                $mail->FromName = "SISTEMA STG";                        // Nome no remetente
                $mail->addAddress($value->cns);                            // Acrescente um destinatário
                $mail->isHTML(true);                                  // Configura o formato do email como HTML
                $mail->Subject = "Revisao";
                $mail->Body = $msg;

//                    $mail->AddAttachment("./upload/nfe/$solicitacao_cliente_id/validada/" . $notafiscal[0]->chave_nfe . '-danfe.pdf', $notafiscal[0]->chave_nfe . '-danfe.pdf');

                if (!$mail->Send()) {
                    $mensagem = "Erro: " . $mail->ErrorInfo;
                } else {
                    $mensagem = "Email enviado com sucesso!";
                }
            }
        }
    }

    function verificaemail() {
        $horario = date("Y-m-d");
        $empresa_id = $this->session->userdata('empresa_id');
        $this->db->select('data_verificacao');
        $this->db->from('tb_empresa_email_verificacao');
        $this->db->where('data_verificacao', $horario);
        $this->db->where('empresa_id', $empresa_id);
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
