<?php

class localizapaciente_model extends Model {

    var $_ambulatorio_pacientetemp_id = null;
    var $_nome = null;
    var $_nascimento = null;
    var $_idade = null;
    var $_celular = null;
    var $_telefone = null;

    function Localizapaciente_model($ambulatorio_pacientetemp_id = null) {
        parent::Model();
        if (isset($ambulatorio_pacientetemp_id)) {
            $this->instanciar($ambulatorio_pacientetemp_id);
        }
    }

    function listarpaciente($nome) {
        $this->db->select('paciente_id,
                            nome,
                            idade,
                            celular,
                            telefone');
        $this->db->from('tb_paciente');
        if (isset($nome) && strlen($nome) > 0) {
            $this->db->where('nome ilike', "%" . $nome . "%");
            $this->db->orwhere('celular ilike', "%" . $nome . "%");
            $this->db->orwhere('telefone ilike', "%" . $nome . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listartemp($nome) {
        $this->db->select('ambulatorio_pacientetemp_id,
                            nome,
                            idade,
                            celular,
                            telefone');
        $this->db->from('tb_ambulatorio_pacientetemp');
        $this->db->where("ativo", 't');
        if (isset($nome) && strlen($nome) > 0) {
            $this->db->where('nome ilike', "%" . $nome . "%");
            $this->db->orwhere('celular ilike', "%" . $nome . "%");
            $this->db->orwhere('telefone ilike', "%" . $nome . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listaragendas($ambulatorio_pacientetemp_id) {
        $this->db->select('agenda_exames_id,
                            inicio,
                            data,
                            nome,
                            observacoes');
        $this->db->from('tb_agenda_exames');
        $this->db->where("ambulatorio_pacientetemp_id", $ambulatorio_pacientetemp_id);
        $return = $this->db->get();
        return $return->result();
    }

    function contadordefinitivo($nome) {
        $this->db->select();
        $this->db->from('tb_paciente');
        if (isset($nome) && strlen($nome) > 0) {
            $this->db->where('nome ilike', "%" . $nome . "%");
            $this->db->orwhere('celular ilike', "%" . $nome . "%");
            $this->db->orwhere('telefone ilike', "%" . $nome . "%");
        }
        $return = $this->db->count_all_results();
        return $return;
    }

    function contadortemp($nome) {
        $this->db->select();
        $this->db->from('tb_ambulatorio_pacientetemp');
        if (isset($nome) && strlen($nome) > 0) {
            $this->db->where('nome ilike', "%" . $nome . "%");
            $this->db->orwhere('celular ilike', "%" . $nome . "%");
            $this->db->orwhere('telefone ilike', "%" . $nome . "%");
        };
        $return = $this->db->count_all_results();
        return $return;
    }

    function contador($ambulatorio_pacientetemp_id) {
        $this->db->select();
        $this->db->from('tb_agenda_exames');
        $this->db->where('ambulatorio_pacientetemp_id', $ambulatorio_pacientetemp_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function gravarexames() {
        try {
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('nascimento', $_POST['nascimento']);
            $this->db->set('idade', $_POST['idade']);
            $this->db->set('celular', $_POST['telefone']);
            $this->db->set('telefone', $_POST['celular']);
            $this->db->where('ambulatorio_pacientetemp_id', $_POST['txtpaciente_id']);
            $this->db->update('tb_ambulatorio_pacientetemp');

            if ($_POST['horarios'] != "") {
                $this->db->set('ativo', 'f');
                $this->db->set('situacao', 'OK');
                $this->db->set('observacoes', $_POST['observacoes']);
                $horario = date("Y-m-d H:i:s");
                $operador_id = $this->session->userdata('operador_id');
                $this->db->set('ambulatorio_pacientetemp_id', $_POST['txtpaciente_id']);
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('agenda_exames_id', $_POST['horarios']);
                $this->db->update('tb_agenda_exames');
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function substituirpacientetemp($paciente_id, $paciente_temp_id) {
        try {
            $i = 0;
            $confimado = "";
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_guia');
            $ambulatorio_guia_id = $this->db->insert_id();
            foreach ($_POST['procedimento'] as $procedimento_tuss_id) {
                $z = 0;
                $y = 0;
                $x = 0;
                $w = 0;
                $b = 0;
                $i++;
                foreach ($_POST['valor'] as $itemnome) {
                    $z++;
                    if ($i == $z) {
                        $valor = $itemnome;
                        break;
                    }
                }
                foreach ($_POST['convenio'] as $itemconvenio) {
                    $w++;
                    if ($i == $w) {
                        $convenio = $itemconvenio;
                        break;
                    }
                }
                foreach ($_POST['autorizacao'] as $itemautorizacao) {
                    $b++;
                    if ($i == $b) {
                        $autorizacao = $itemautorizacao;
                        break;
                    }
                }
                foreach ($_POST['agenda_exames_id'] as $itemagenda_exames_id) {
                    $x++;
                    if ($i == $x) {
                        $agenda_exames_id = $itemagenda_exames_id;
                        break;
                    }
                }
                foreach ($_POST['confimado'] as $key => $itemconfimado) {
                    $y++;
                    if ($i == $key) {
                        $confimado = $itemconfimado;
                        break;
                    }
                }
                $procedimento_tuss_id = (int) $procedimento_tuss_id;
                $agenda_exames_id = (int) $agenda_exames_id;
                if ($confimado == "on" && $procedimento_tuss_id > 0) {
                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('procedimento_tuss_id', $procedimento_tuss_id);
                    $this->db->set('convenio_id', $convenio);
                    $this->db->set('autorizacao', $autorizacao);
                    $this->db->set('guia_id', $ambulatorio_guia_id);
                    $this->db->set('valor', str_replace(",", ".", str_replace(".", "", $valor)));
                    $this->db->set('confirmado', 't');
                    $horario = date("Y-m-d H:i:s");
                    $operador_id = $this->session->userdata('operador_id');
                    $this->db->set('ambulatorio_pacientetemp_id', null);
                    $this->db->set('data_atualizacao', $horario);
                    $this->db->set('operador_atualizacao', $operador_id);
                    $this->db->where('agenda_exames_id', $agenda_exames_id);
                    $this->db->update('tb_agenda_exames');
                    $confimado = "";
                }
            }
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarautocompletehorarios($parametro = null, $teste = null) {
        $this->db->select('a.agenda_exames_id,
                            ae.nome,
                            a.inicio,
                            a.fim,
                            a.data');
        $this->db->from('tb_agenda_exames a');
        $this->db->join('tb_agenda_exames_nome ae', 'ae.agenda_exames_nome_id = a.agenda_exames_nome_id', 'left');
        $this->db->where('a.ativo', 'true');
        $this->db->orderby('a.inicio');
        if ($parametro != null) {
            $this->db->where('ae.nome ilike', "%" . $parametro . "%");
            $this->db->where('a.data', $teste);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentos($parametro) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome as procedimento');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_convenio c', 'c.convenio_id = pc.convenio_id', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id', 'left');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.convenio_id', $parametro);
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompleteprocedimentosvalor($parametro = null) {
        $this->db->select('pc.valortotal');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->where("pc.ativo", 't');
        $this->db->where('pc.procedimento_convenio_id', $parametro);
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemodelos($parametro = null) {
        $this->db->select('ambulatorio_modelo_laudo_id,
                            nome,
                            texto');
        $this->db->from('tb_ambulatorio_modelo_laudo');
        $this->db->where('ativo', 'true');
        $this->db->orderby('nome');
        if ($parametro != null) {
            $this->db->where('nome ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function excluir($agenda_exames_id) {

        $this->db->set('ativo', 't');
        $this->db->set('situacao', 'LIVRE');
        $this->db->set('observacoes', "");
        $horario = date("Y-m-d H:i:s");
        $operador_id = $this->session->userdata('operador_id');
        $this->db->set('ambulatorio_pacientetemp_id', null);
        $this->db->set('data_atualizacao', $horario);
        $this->db->set('operador_atualizacao', $operador_id);
        $this->db->where('agenda_exames_id', $agenda_exames_id);
        $this->db->update('tb_agenda_exames');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") // erro de banco
            return false;
        else
            return true;
    }

    function criar() {

        $this->db->set('nome', '');
        $this->db->insert('tb_ambulatorio_pacientetemp');
        $ambulatorio_pacientetemp_id = $this->db->insert_id();

        return $ambulatorio_pacientetemp_id;
    }

    function gravar() {
        try {

            /* inicia o mapeamento no banco */
            $procedimento_tuss_id = $_POST['txtprocedimentotussid'];
            $this->db->set('nome', $_POST['txtNome']);
            $this->db->set('tuss_id', $_POST['txtprocedimento']);
            $this->db->set('codigo', $_POST['txtcodigo']);
            $this->db->set('descricao', $_POST['txtdescricao']);

            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['txtprocedimentotussid'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_procedimento_tuss');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") // erro de banco
                    return -1;
                else
                    $procedimento_tuss_id = $this->db->insert_id();
            }
            else { // update
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $procedimento_tuss_id = $_POST['txtprocedimentotussid'];
                $this->db->where('procedimento_tuss_id', $procedimento_tuss_id);
                $this->db->update('tb_procedimento_tuss');
            }

            return $servidor_id;
        } catch (Exception $exc) {
            return -1;
        }
    }

    private function instanciar($ambulatorio_pacientetemp_id) {

        if ($ambulatorio_pacientetemp_id != 0) {
            $this->db->select('nome, nascimento, idade, celular, telefone');
            $this->db->from('tb_ambulatorio_pacientetemp');
            $this->db->where("ambulatorio_pacientetemp_id", $ambulatorio_pacientetemp_id);
            $query = $this->db->get();
            $return = $query->result();
            $this->_ambulatorio_pacientetemp_id = $ambulatorio_pacientetemp_id;

            $this->_nome = $return[0]->nome;
            $this->_nascimento = $return[0]->nascimento;
            $this->_idade = $return[0]->idade;
            $this->_celular = $return[0]->celular;
            $this->_telefone = $return[0]->telefone;
        } else {
            $this->_ambulatorio_pacientetemp_id = null;
        }
    }

}

?>
