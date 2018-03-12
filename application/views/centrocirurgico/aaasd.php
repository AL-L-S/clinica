<?php

  function gravarguiacirurgicaequipe($procedimentos, $guia) {
//        var_dump($procedimentos);die;
        $valMedico = 0;
        for ($i = 0; $i < count($procedimentos); $i++) {
            $valor = (float) $procedimentos[$i]->valor_total;
            $valProcedimento = ($procedimentos[$i]->horario_especial == 't') ? ($valor) + ($valor * (30 / 100)) : $valor;
            if ($guia->leito == 'ENFERMARIA') { //LEITO DE ENFERMARIA
                if ($guia->via == 'D') { // VIA DIFERENTE
                    if ($i == 0) {
                        $valMedicoProc = $valProcedimento;
                    } else {
                        $valMedicoProc = ($valProcedimento * (70 / 100));
                    }
                } elseif ($guia->via == 'M') { // MESMA VIA
                    if ($i == 0) {
                        $valMedicoProc = $valProcedimento;
                    } else {
                        $valMedicoProc = ($valProcedimento * (50 / 100));
                    }
                }
            } else { //APARTAMENTO
                if ($guia->via == 'D') {// VIA DIFERENTE
                    if ($i == 0) {
                        $valMedicoProc = 2 * $valProcedimento;
                    } else {
                        $valMedicoProc = ($valProcedimento * (140 / 100));
                    }
                } elseif ($guia->via == 'M') {// MESMA VIA
                    if ($i == 0) {
                        $valMedicoProc = 2 * $valProcedimento;
                    } else {
                        $valMedicoProc = $valProcedimento;
                    }
                }
            }
            //VALOR DO CIRURGIAO/ANESTESISTA
            $valMedico = $valMedicoProc;
//        }
            //definindo os valores 
            if ((int) $_POST['funcao'] == 0) {
                $val = number_format($valMedico, 2, '.', '');
            } elseif ((int) $_POST['funcao'] == 6) {
                $val = number_format($valMedico, 2, '.', '');
            } elseif ((int) $_POST['funcao'] == 1) {
                $val = number_format(($valMedico * (30 / 100)), 2, '.', '');
            } else {
                $val = number_format(($valMedico * (20 / 100)), 2, '.', '');
            }
//        $i = 0;
//        foreach ($procedimentos as $value) {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('operador_responsavel', $_POST['medico']);
            $this->db->set('agenda_exames_id', $procedimentos[$i]->agenda_exames_id);
//            $this->db->set('guia_id', $guia->ambulatorio_guia_id);
            $this->db->set('valor', $val);
            $this->db->set('funcao', $_POST['funcao']);
            $this->db->insert('tb_agenda_exame_equipe');
        }
    }
