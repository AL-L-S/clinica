<?php

require_once APPPATH . 'models/base/BaseModel.php';

//require_once APPPATH . 'models/base/ConvertXml.php';



class internacao_model extends BaseModel {

    var $_paciente_id = null;
    var $_nome = null;

    function internacao_model($emergencia_solicitacao_acolhimento_id = null) {
        parent::Model();
        if (isset($emergencia_solicitacao_acolhimento_id)) {
            $this->instanciar($emergencia_solicitacao_acolhimento_id);
        }
    }

    function gravar($paciente_id) {

        try {
            $this->db->set('leito', $_POST['txtleito']);
            $this->db->set('codigo', $_POST['sisreg']);
            $this->db->set('aih', $_POST['aih']);
            $this->db->set('prelaudo', $_POST['central']);
            $this->db->set('medico_id', $_POST['operadorID']);
            $this->db->set('data_internacao', $_POST['data']);
            $this->db->set('forma_de_entrada', $_POST['forma']);
            $this->db->set('estado', $_POST['estado']);
            $this->db->set('carater_internacao', $_POST['carater']);
            if ($_POST['hospital'] != "Selecione") {
                $this->db->set('hospital', $_POST['hospital']);
            }

            $this->db->set('procedimentosolicitado', $_POST['procedimentoID']);
            $this->db->set('cid1solicitado', $_POST['cid1ID']);
            $this->db->set('cid2solicitado', $_POST['cid2ID']);
            $this->db->set('justificativa', $_POST['observacao']);
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else
                    $internacao_id = $this->db->insert_id();
            }
            else { // update
                $internacao_id = $_POST['internacao_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_id', $internacao_id);
                $this->db->update('tb_internacao');
            }


            return $internacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function listardadospaciente($internacao_id) {

        $this->db->select('p.nome as paciente,
                           p.paciente_id,
                           i.data_internacao,
                           p.sexo,
                           p.nascimento,
                           il.nome as leito,
                           o.nome as medico');
        $this->db->from('tb_internacao i');
        $this->db->where('i.internacao_id', $internacao_id);
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = i.leito');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id');
        $this->db->where('il.ativo', 'f');
        $this->db->where('i.ativo', 't');

        $return = $this->db->get();
        return $return->result();
    }

    function gravarinternacaonutricao($paciente_id) {

        try {
            if ($_POST['leito'] != "") {
                $this->db->set('leito', $_POST['leito']);
            }
            $this->db->set('codigo', $_POST['sisreg']);
            $this->db->set('aih', $_POST['aih']);
            if ($_POST['unidade'] != "") {
                $this->db->set('hospital_id', $_POST['unidade']);
            }
            if ($_POST['data_internacao'] != "") {
                $this->db->set('data_internacao', $_POST['data_internacao']);
            }
            if ($_POST['data_solicitacao'] != "") {
                $this->db->set('data_solicitacao', $_POST['data_solicitacao']);
            }
            $this->db->set('carater_internacao', $_POST['carater']);
            $this->db->set('procedimentosolicitado', $_POST['procedimentoID']);
            $this->db->set('cid1solicitado', $_POST['cid1ID']);
            $this->db->set('justificativa', $_POST['observacao']);
            $this->db->set('solicitante', $_POST['solicitante']);
            $this->db->set('reg', $_POST['reg']);
            $this->db->set('val', $_POST['val']);
            $this->db->set('pla', $_POST['pla']);
            $this->db->set('rx', $_POST['rx']);
            $this->db->set('acesso', $_POST['acesso']);
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            // $this->db->set('paciente_id',$_POST['txtPacienteId'] );

            if ($_POST['internacao_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao');
                $internacao_id = $this->db->insert_id();
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return 0;
                } elseif ($_POST['leito'] != "") {
                    $this->db->set('ativo', 'false');
                    $this->db->set('condicao', 'Ocupado');
                    $this->db->where('internacao_leito_id', $_POST['leito']);
                    $this->db->update('tb_internacao_leito');

                    $this->db->set('paciente_id', $paciente_id);
                    $this->db->set('leito_id', $_POST['leito']);
                    $this->db->set('ocupado', 'false');
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_internacao_ocupacao');
                }
            } else { // update
                $internacao_id = $_POST['internacao_id'];
                $this->db->set('data_atualizacao', $horario);
                $this->db->set('operador_atualizacao', $operador_id);
                $this->db->where('internacao_id', $internacao_id);
                $this->db->update('tb_internacao');
            }


            return $internacao_id;
        } catch (Exception $exc) {
            return 0;
        }
    }

    function listarEvolucao($internacao_id) {

        $this->db->select('internacao_evolucao_id,
                                internacao_id,
                                diagnostico,
                                conduta,
                                data_cadastro');
        $this->db->from('tb_internacao_evolucao');
        $this->db->where('internacao_id', $internacao_id);
        $this->db->where('ativo', 't');
        $this->db->orderby('internacao_evolucao_id');

        $return = $this->db->get();
        return $return->result();
    }

    function gravarevolucaointernacao() {

        try {
            $operador_id = ($this->session->userdata('operador_id'));
            $horario = date("Y-m-d H:i:s");

            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('diagnostico', $_POST['txtdiagnostico']);
            $this->db->set('conduta', $_POST['txtconduta']);
            $this->db->set('internacao_id', $_POST['internacao_id']);
            $this->db->set('data_cadastro', $horario);
            $this->db->insert('tb_internacao_evolucao');
        } catch (Exception $exc) {
            $return = 0;
            return $return;
        }
    }

    function excluirevolucaointernacao($internacao_evolucao_id) {

        try {
            $operador_id = ($this->session->userdata('operador_id'));
            $horario = date("Y-m-d H:i:s");

            $this->db->set('ativo', 'f');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('internacao_evolucao_id', $internacao_evolucao_id);
            $this->db->update('tb_internacao_evolucao');
        } catch (Exception $exc) {
            $return = 0;
            return $return;
        }
    }

    function gravarprescricaoenteralnormal($internacao_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('internacao_precricao_id');
        $this->db->from('tb_internacao_precricao');
        $this->db->where("internacao_id", $internacao_id);
        $this->db->where("data", $dataprescricao);
        $query = $this->db->get();
        $return = $query->result();

        $numero = count($return);

        if ($numero == 0) {
            $this->db->set('data', $dataprescricao);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao');
            $internacao_precricao_id = $this->db->insert_id();
        } else {
            $internacao_precricao_id = $return[0]->internacao_precricao_id;
        }

        if ($_POST['produto'] != "Selecione") {

            $this->db->set('etapas', $_POST['etapas']);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id = $this->db->insert_id();

            $i = 0;
            foreach ($_POST['produto'] as $produto) {
                $z = 0;
                $c = 0;
                $i++;
                foreach ($_POST['volume'] as $itemvolume) {
                    $c++;
                    if ($i == $c) {
                        $volume = $itemvolume;
                        break;
                    }
                }
                foreach ($_POST['vazao'] as $itemvazao) {
                    $z++;
                    if ($i == $z) {
                        $vazao = $itemvazao;
                        break;
                    }
                }

                $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id);
                $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                $this->db->set('internacao_id', $internacao_id);
                $this->db->set('etapas', $_POST['etapas']);
                $this->db->set('tipo', 'ENTERALNORMAL');
                if ($produto != "Selecione") {
                    $this->db->set('produto_id', $produto);
                }
                if ($volume != null) {
                    $this->db->set('volume', $volume);
                }
                if ($vazao != null) {
                    $this->db->set('vasao', $vazao);
                }
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_precricao_produto');
                $internacao_precricao_produto_id = $this->db->insert_id();
            }
        }

        if ($_POST['equipo'] != "Selecione") {

            $this->db->set('etapas', 1);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id_equipo = $this->db->insert_id();

            $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id_equipo);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('etapas', 1);
            $this->db->set('tipo', 'ENTERALNORMAL');
            $this->db->set('produto_id', $_POST['equipo']);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_produto');
        }
    }

    function gravarprescricaoenteralemergencial($internacao_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('internacao_precricao_id');
        $this->db->from('tb_internacao_precricao');
        $this->db->where("internacao_id", $internacao_id);
        $this->db->where("data", $dataprescricao);
        $query = $this->db->get();
        $return = $query->result();

        $numero = count($return);

        if ($numero == 0) {
            $this->db->set('data', $dataprescricao);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao');
            $internacao_precricao_id = $this->db->insert_id();
        } else {
            $internacao_precricao_id = $return[0]->internacao_precricao_id;
        }

        if ($_POST['produto'] != "Selecione") {

            $this->db->set('etapas', $_POST['etapas']);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id = $this->db->insert_id();

            $i = 0;
            foreach ($_POST['produto'] as $produto) {
                $z = 0;
                $c = 0;
                $i++;
                foreach ($_POST['volume'] as $itemvolume) {
                    $c++;
                    if ($i == $c) {
                        $volume = $itemvolume;
                        break;
                    }
                }
                foreach ($_POST['vazao'] as $itemvazao) {
                    $z++;
                    if ($i == $z) {
                        $vazao = $itemvazao;
                        break;
                    }
                }

                $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id);
                $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                $this->db->set('internacao_id', $internacao_id);
                $this->db->set('etapas', $_POST['etapas']);
                $this->db->set('tipo', 'ENTERALEMERGENCIAL');
                if ($produto != "Selecione") {
                    $this->db->set('produto_id', $produto);
                }
                if ($volume != null) {
                    $this->db->set('volume', $volume);
                }
                if ($vazao != null) {
                    $this->db->set('vasao', $vazao);
                }
                $this->db->set('empresa_id', $empresa_id);
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->insert('tb_internacao_precricao_produto');
                $internacao_precricao_produto_id = $this->db->insert_id();
            }
        }

        if ($_POST['equipo'] != "Selecione") {

            $this->db->set('etapas', 1);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_etapa');
            $internacao_precricao_etapa_id_equipo = $this->db->insert_id();

            $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id_equipo);
            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('etapas', 1);
            $this->db->set('tipo', 'ENTERALEMERGENCIAL');
            $this->db->set('produto_id', $_POST['equipo']);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao_produto');
        }
    }

    function repetirultimaprescicaoenteralnormal($internacao_id) {

        $empresa_id = $this->session->userdata('empresa_id');
        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        $this->db->select('internacao_precricao_id');
        $this->db->from('tb_internacao_precricao');
        $this->db->where("internacao_id", $internacao_id);
        $query = $this->db->get();
        $row = $query->last_row();

        $numero = count($row->internacao_precricao_id);
        if ($numero > 0) {
            $this->db->set('data', $dataprescricao);
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('empresa_id', $empresa_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_precricao');
            $internacao_precricao_id = $this->db->insert_id();

            $this->db->select('internacao_precricao_etapa_id, etapas');
            $this->db->from('tb_internacao_precricao_etapa');
            $this->db->where("internacao_precricao_id", $row->internacao_precricao_id);
            $query = $this->db->get();
            $returno = $query->result();
            $numeroetapa = count($returno);

            if ($numeroetapa > 0) {
                foreach ($returno as $item) {
                    $this->db->set('etapas', $item->etapas);
                    $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                    $this->db->set('empresa_id', $empresa_id);
                    $this->db->set('data_cadastro', $horario);
                    $this->db->set('operador_cadastro', $operador_id);
                    $this->db->insert('tb_internacao_precricao_etapa');
                    $internacao_precricao_etapa_id = $this->db->insert_id();

                    $this->db->select('internacao_precricao_id, internacao_id, etapas, produto_id, volume, vasao');
                    $this->db->from('tb_internacao_precricao_produto');
                    $this->db->where("internacao_precricao_etapa_id", $item->internacao_precricao_etapa_id);
                    $query = $this->db->get();
                    $return = $query->result();
                    $numeroproduto = count($return);


                    if ($numeroproduto > 0) {
                        foreach ($return as $value) {
                            $this->db->set('internacao_precricao_etapa_id', $internacao_precricao_etapa_id);
                            $this->db->set('internacao_precricao_id', $internacao_precricao_id);
                            $this->db->set('internacao_id', $value->internacao_id);
                            $this->db->set('etapas', $value->etapas);
                            $this->db->set('tipo', 'ENTERALNORMAL');
                            if ($value->produto_id != "") {
                                $this->db->set('produto_id', $value->produto_id);
                            }
                            if ($value->volume != "") {
                                $this->db->set('volume', $value->volume);
                            }
                            if ($value->vasao != "") {
                                $this->db->set('vasao', $value->vasao);
                            }
                            $this->db->set('empresa_id', $empresa_id);
                            $this->db->set('data_cadastro', $horario);
                            $this->db->set('operador_cadastro', $operador_id);
                            $this->db->insert('tb_internacao_precricao_produto');
                        }
                    }
                }
            }
        }
    }

    function gravarmovimentacao($paciente_id, $leito_id) {

        try {
            $this->db->set('leito_id', $_POST['leitoID']);
            $this->db->set('paciente_id', $paciente_id);
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');


            $this->db->set('paciente_id', $paciente_id);
            $this->db->set('leito_id', $_POST['leitoID']);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_ocupacao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                $internacao_ocupacao_id = $this->db->insert_id();

                $this->db->set('ativo', 'false');
                $this->db->where('internacao_leito_id', $_POST['leitoID']);
                $this->db->update('tb_internacao_leito');

                $this->db->set('ativo', 'true');
                $this->db->where('internacao_leito_id', $leito_id);
                $this->db->update('tb_internacao_leito');
            }
            return $internacao_ocupacao_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function excluiritemprescicao($item_id) {

        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->set('ativo', 'false');
            $this->db->where('internacao_precricao_produto_id', $item_id);
            $this->db->update('tb_internacao_precricao_produto');
            return $item_id;
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarprescricaofarmacia($internacao_id) {

        $horario = date("Y-m-d H:i:s");
        $dataprescricao = date("Y-m-d");
        $operador_id = $this->session->userdata('operador_id');

        //inserindo na tabela internacao_prescricao... falta pegar o id de prescricao e jpgar na view...
        if ($_POST["prescricaoID"] == '') {
            $this->db->set('internacao_id', $internacao_id);
            $this->db->set('data_cadastro', $horario);
            $this->db->set('data', $dataprescricao);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_internacao_prescricao');
            $prescricao_id = $this->db->insert_id();
        } else {
            $prescricao_id = $_POST["prescricaoID"];
        }

        $this->db->set('internacao_prescricao_id', $prescricao_id);
        $this->db->set('internacao_id', $internacao_id);
        $this->db->set('medicamento_id', $_POST['txtMedicamentoID']);
        $this->db->set('aprasamento', $_POST['aprasamento']);
        $this->db->set('dias', $_POST['dias']);
        $this->db->set('volume', $_POST['volume']);
        $this->db->set('data_cadastro', $horario);
        $this->db->set('operador_cadastro', $operador_id);
        $this->db->insert('tb_internacao_prescricao_medicamento');
        if (trim($erro) != "") { // erro de banco
            return false;
        } else {
            return $prescricao_id;
        }
    }

    function listardadosreceituario($internacao_id) {
        $this->db->select('p.nome, 
                           pr.descricao_resumida as procedimento, 
                           i.solicitante, 
                           i.leito as sala, 
                           i.paciente_id, 
                           p.nascimento,
                           pr.procedimento_id');
        $this->db->from('tb_internacao i');
        $this->db->where("i.internacao_id = $internacao_id");
        $this->db->join('tb_paciente p', "i.paciente_id = p.paciente_id");
        $this->db->join('tb_procedimento pr', "pr.procedimento_id = i.procedimentosolicitado");
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemodelosreceita($parametro = null) {
        $this->db->select('nome,
                           protoatendimento_modelo_receita_id,
                           texto');
        $this->db->from('tb_protoatendimento_modelo_receita');
        $this->db->where("ativo", 't');
        if ($parametro != null) {
            $this->db->where('protoatendimento_modelo_receita_id', $parametro);
        }
        $return = $this->db->get();
        return $return->result();
    }

    private function instanciar($paciente_id) {
        if ($paciente_id != 0) {

            $this->db->select('tp.tipo_logradouro_id as codigo_logradouro,tp.descricao,p.*,c.nome as cidade_desc,c.municipio_id as cidade_cod,e.estado_id as uf_cod, e.nome as uf_desc');
            $this->db->from('tb_paciente p');
            $this->db->join('tb_municipio c', 'c.municipio_id = p.municipio_id', 'left');
            $this->db->join('tb_estado e', 'e.estado_id = p.uf_rg', 'left');
            $this->db->join('tb_tipo_logradouro tp', 'p.tipo_logradouro = tp.tipo_logradouro_id', 'left');
            $this->db->where("paciente_id", $paciente_id);
            $query = $this->db->get();
            $return = $query->result();

            $this->_paciente_id = $paciente_id;
            $this->_cpf = $return[0]->cpf;
            $this->_nome = $return[0]->nome;
            $this->_cns = $return[0]->cns;
            if (isset($return[0]->nascimento)) {
                $this->_nascimento = $return[0]->nascimento;
            }
            $this->_idade = $return[0]->idade;
            $this->_documento = $return[0]->rg;
            $this->_estado_id_expedidor = $return[0]->uf_rg;
            $this->_titulo_eleitor = $return[0]->titulo_eleitor;
            $this->_raca_cor = $return[0]->raca_cor;
            $this->_sexo = $return[0]->sexo;
            $this->_estado_civil = $return[0]->estado_civil_id;
            $this->_nomepai = $return[0]->nome_pai;
            $this->_nomemae = $return[0]->nome_mae;
            $this->_telMae = $return[0]->telefone_mae;
            $this->_telefone = $return[0]->telefone;
            $this->_tipoLogradouro = $return[0]->codigo_logradouro;
            $this->_numero = $return[0]->numero;
            $this->_rua = $return[0]->logradouro;
            $this->_bairro = $return[0]->bairro;
            $this->_cidade = $return[0]->municipio_id;
            $this->_cep = $return[0]->cep;
            $this->_observacao = $return[0]->observacao;
            $this->_complemento = $return[0]->complemento;
            $this->_estado_expedidor = $return[0]->uf_desc;
            $this->_estado_id_expedidor = $return[0]->uf_cod;
            $this->_cidade_nome = $return[0]->cidade_desc;
            $this->_data_emissao = $return[0]->data_emissao;
        }
    }

    function listaunidade() {
        $this->db->select(' internacao_unidade_id,
                            nome');
        $this->db->from('tb_internacao_unidade');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function usafarmacia() {
        $this->db->select(' empresa_id,
                            nome');
        $this->db->from('tb_empresa');
        $this->db->where('farmacia', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function pesquisarunidade($unidade_id) {
        $this->db->select(' internacao_unidade_id,
                            nome');
        $this->db->from('tb_internacao_unidade');
        $this->db->where('internacao_unidade_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listapacienteinternado($paciente_id) {
        $this->db->select(' p.nome as paciente,
                            p.paciente_id,
                            il.nome as leito,
                            i.leito as leito_id');
        $this->db->from('tb_internacao i, tb_paciente p, tb_internacao_leito il');
        $this->db->where('p.paciente_id', $paciente_id);
        $this->db->where('i.paciente_id', $paciente_id);
        $this->db->where('i.leito = il.internacao_leito_id');
        $this->db->where('il.ativo', 'f');
        $return = $this->db->get();
        return $return->result();
    }

    function empresa() {
        $empresa = $this->session->userdata('empresa_id');
        $this->db->select('empresa_id,
                            nome,
                            cnpj,
                            cep,
                            razao_social,
                            logradouro,
                            bairro,
                            telefone,
                            internacao,
                            numero');
        $this->db->from('tb_empresa');
        $this->db->where('empresa_id', $empresa);
        $return = $this->db->get();
        return $return->result();
    }

    function imprimirevolucaointernacao($internacao_evolucao_id) {
        $this->db->select('ie.internacao_evolucao_id,
                               ie.internacao_id,
                                ie.diagnostico,
                                p.nome as paciente,
                                p.paciente_id,
                                p.rg,
                                p.nascimento,
                                p.sexo,
                                p.nome_mae,
                                p.telefoneresp,
                                p.nomeresp,
                                p.logradouro,
                                p.numero,
                                p.complemento,
                                m.estado,
                                m.nome as municipio,
                                m.codigo_ibge,
                                p.cep,
                                cid.no_cid as cid,
                                cid.co_cid as cod,
                                
                                ie.conduta,
                                ie.data_cadastro');
        $this->db->from('tb_internacao_evolucao ie');
        $this->db->join('tb_internacao i', 'ie.internacao_id = i.internacao_id ', 'left');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ', 'left');
        $this->db->join('tb_municipio m', 'm.municipio_id = p.municipio_id', 'left');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado', 'left');
        $this->db->where('internacao_evolucao_id', $internacao_evolucao_id);

        $return = $this->db->get();
        return $return->result();
    }

    function listaprodutosenteral($internacao_id) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_paciente p', 'p.convenio_id = pc.convenio_id ');
        $this->db->join('tb_internacao i', 'i.paciente_id = p.paciente_id ');
        $this->db->where('i.internacao_id', $internacao_id);
        $this->db->where('pt.grupo', 'ENTERAL');
        $this->db->where('pc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprodutosequipo($internacao_id) {
        $this->db->select(' pc.procedimento_convenio_id,
                            pt.nome');
        $this->db->from('tb_procedimento_convenio pc');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_paciente p', 'p.convenio_id = pc.convenio_id ');
        $this->db->join('tb_internacao i', 'i.paciente_id = p.paciente_id ');
        $this->db->where('i.internacao_id', $internacao_id);
        $this->db->where('pt.grupo', 'EQUIPO');
        $this->db->where('pc.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesenteral($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ', 'left');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ', 'left');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('ipp.tipo', 'ENTERALNORMAL');
        $this->db->where('ip.data', $data);
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesenteralemergencial($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ', 'left');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ', 'left');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ', 'left');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ', 'left');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('ipp.tipo', 'ENTERALEMERGENCIAL');
        $this->db->where('ip.data', $data);
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoespaciente($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ip.data,
                            ip.internacao_precricao_id,
                            ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('pt.grupo !=', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoespacienteequipo($internacao_id) {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_id,
                            ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->where('ipp.internacao_id', $internacao_id);
        $this->db->where('pt.grupo', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesdata() {
        $data = date("Y-m-d");
        $this->db->select(' ip.data,
                            ip.internacao_precricao_id,
                            ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome,
                            p.nome as paciente');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->join('tb_internacao i', 'i.internacao_id = ip.internacao_id');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id');
        $this->db->where('ip.data >=', $_POST['txtdata_inicio']);
        $this->db->where('ip.data <=', $_POST['txtdata_fim']);
        $this->db->where('ipp.tipo', $_POST['tipo']);
        if ($_POST['unidade'] != 0) {
            $this->db->where('i.hospital_id', $_POST['unidade']);
        }
        $this->db->where('pt.grupo !=', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaprescricoesequipodata() {
        $data = date("Y-m-d");
        $this->db->select(' ipp.internacao_precricao_produto_id,
                            ipe.internacao_precricao_etapa_id,
                            ipe.internacao_precricao_etapa_id,
                            ipp.etapas,
                            ipp.volume,
                            ipp.vasao,
                            pt.nome');
        $this->db->from('tb_internacao_precricao_produto ipp');
        $this->db->join('tb_internacao_precricao_etapa ipe', 'ipe.internacao_precricao_etapa_id = ipp.internacao_precricao_etapa_id ');
        $this->db->join('tb_procedimento_convenio pc', 'pc.procedimento_convenio_id = ipp.produto_id ');
        $this->db->join('tb_procedimento_tuss pt', 'pt.procedimento_tuss_id = pc.procedimento_tuss_id ');
        $this->db->join('tb_internacao_precricao ip', 'ip.internacao_precricao_id = ipp.internacao_precricao_id ');
        $this->db->join('tb_internacao i', 'i.internacao_id = ip.internacao_id');
        $this->db->where('ip.data >=', $_POST['txtdata_inicio']);
        $this->db->where('ip.data <=', $_POST['txtdata_fim']);
        $this->db->where('ipp.tipo', $_POST['tipo']);
        if ($_POST['unidade'] != 0) {
            $this->db->where('i.hospital_id', $_POST['unidade']);
        }
        $this->db->where('pt.grupo', 'EQUIPO');
        $this->db->where('ipp.ativo', 't');
        $this->db->orderby('pt.grupo');
        $this->db->orderby('ipe.internacao_precricao_etapa_id');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitointarnacao($unidade_id) {
        $this->db->select(' il.internacao_leito_id,
                            il.nome');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('il.ativo', 't');
        $this->db->where('il.condicao', 'Vago');
        $this->db->where('iu.internacao_unidade_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitointarnacao2($unidade_id) {
        $this->db->select(' il.internacao_leito_id,
                            il.nome as leito,
                            ie.nome as enfermaria');
        $this->db->from('tb_internacao_leito il, tb_internacao_enfermaria ie');
        $this->db->where('ie.internacao_enfermaria_id = il.enfermaria_id');
        $this->db->where('il.ativo', 't');
        $this->db->where('il.excluido', 'f');
        $this->db->where('il.condicao', 'Vago');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('iu.internacao_unidade_id', $unidade_id);
        $return = $this->db->get();
        return $return->result();
    }

    function listapacienteunidade($unidade) {
        $this->db->select(' p.nome as paciente,
                            p.paciente_id,
                            il.internacao_leito_id as leito_id,
                            il.nome as leito,
                            ie.nome as enfermaria');
        $this->db->from('tb_paciente p, tb_internacao i, tb_internacao_leito il, tb_internacao_enfermaria ie');
        $this->db->where('i.paciente_id = p.paciente_id');
        $this->db->where('i.leito = il.internacao_leito_id');
        $this->db->where('il.ativo', 'f');
        $this->db->where('i.ativo', 't');
        $this->db->where('ie.internacao_enfermaria_id = il.enfermaria_id');
        $this->db->where('ie.unidade_id', $unidade);


        $return = $this->db->get();
        return $return->result();
    }

    function listaunidadecondicao($condicao) {
        $sql = "SELECT DISTINCT iu.nome,
                       iu.internacao_unidade_id
                FROM ponto.tb_internacao_leito il, ponto.tb_internacao_enfermaria ie, ponto.tb_internacao_unidade iu
                WHERE ie.internacao_enfermaria_id = il.enfermaria_id
                AND iu.internacao_unidade_id = ie.unidade_id 
                AND il.excluido = 'f' ";
        if ($condicao == "Ocupado") {
            $sql .= "AND il.ativo = 'f'";
        } else {
            $sql .= "AND il.ativo = 't'
                AND il.condicao = '$condicao'";
        }
        $return = $this->db->query($sql);
        return $return->result();
    }

    function listaunidadetransferencia($condicao = '') {
        $this->db->select('iu.internacao_unidade_id,
                           iu.nome as unidade');
        $this->db->from('tb_internacao_unidade iu');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaenfermariatransferencia() {
        $this->db->select('ie.internacao_enfermaria_id,
                           ie.nome as enfermaria,
                           ie.unidade_id');
        $this->db->from('tb_internacao_enfermaria ie');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleitotransferencia() {
        $this->db->select('il.internacao_leito_id as leito_id,
                           il.nome as leito,
                           il.enfermaria_id');
        $this->db->from('tb_internacao_leito il');
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function pegaidpacientepermuta($leito_id) {
        //pegando o id do paciente permutado
        $this->db->select('i.paciente_id');
        $this->db->from('tb_internacao i');
        $this->db->where('i.leito', $leito_id);
        $this->db->where('i.ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function permutapacientes() {
        //trocando os leito na tabela internacao
        $this->db->set('leito', $_POST['leito_troca']);
        $this->db->where('paciente_id', $_POST['paciente_id_selecionado']);
        $this->db->update('tb_internacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }

        $this->db->set('leito', $_POST['leito_id_selecionado']);
        $this->db->where('paciente_id', $_POST['id_paciente_troca'][0]->paciente_id);
        $this->db->update('tb_internacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }

        //atualizando a tabela ocupacao
        $this->db->set('ocupado', 'f');
        $this->db->where('paciente_id', $_POST['paciente_id_selecionado']);
        $this->db->where('leito_id', $_POST['leito_id_selecionado']);
        $this->db->update('tb_internacao_ocupacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
        $this->db->set('ocupado', 'f');
        $this->db->where('paciente_id', $_POST['id_paciente_troca'][0]->paciente_id);
        $this->db->where('leito_id', $_POST['leito_troca']);
        $this->db->update('tb_internacao_ocupacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }

        //inserindo na tabela ocupacao
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('paciente_id', $_POST['paciente_id_selecionado']);
            $this->db->set('leito_id', $_POST['leito_troca']);
            $this->db->set('ocupado', 't');
            $this->db->insert('tb_internacao_ocupacao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                $this->db->insert_id();
            }

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->set('paciente_id', $_POST['id_paciente_troca'][0]->paciente_id);
            $this->db->set('leito_id', $_POST['leito_id_selecionado']);
            $this->db->set('ocupado', 't');
            $this->db->insert('tb_internacao_ocupacao');
            $erro = $this->db->_error_message();
            if (trim($erro) != "") { // erro de banco
                return false;
            } else {
                $this->db->insert_id();
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function transferirpacienteleito() {

        //atualizando o leito na tabela internacao e ocupacao
        $this->db->set('leito', $_POST['novo_leito']);
        $this->db->where('paciente_id', $_POST['paciente_id']);
        $this->db->update('tb_internacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }

        $this->db->set('ocupado', 'f');
        $this->db->where('paciente_id', $_POST['paciente_id']);
        $this->db->where('leito_id', $_POST['leito_id']);
        $this->db->update('tb_internacao_ocupacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }


        //inserindo na tabela ocupacao
        try {
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            if ($_POST['internacao_unidade_id'] == "") {// insert
                $this->db->set('data_cadastro', $horario);
                $this->db->set('operador_cadastro', $operador_id);
                $this->db->set('paciente_id', $_POST['paciente_id']);
                $this->db->set('leito_id', $_POST['novo_leito']);
                $this->db->set('ocupado', 't');
                $this->db->insert('tb_internacao_ocupacao');
                $erro = $this->db->_error_message();
                if (trim($erro) != "") { // erro de banco
                    return false;
                } else {
                    $internacao_unidade_id = $this->db->insert_id();
                }
            }
        } catch (Exception $exc) {
            return false;
        }
    }

    function gravarreceituariointernacao($internacao_id) {
        try {

            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');

            $this->db->set('texto', $_POST['laudo']);
            $this->db->set('paciente_id', $_POST['paciente_id']);
            $this->db->set('procedimento_tuss_id', $_POST['procedimento']);
            $this->db->set('laudo_id', $internacao_id);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('tipo', 'NORMAL');

            $this->db->set('data_cadastro', $horario);
            $this->db->set('operador_cadastro', $operador_id);
            $this->db->insert('tb_ambulatorio_receituario');


            $erro = $this->db->_error_message();
            if (trim($erro) != "") // erro de banco
                return -1;
            return 0;
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarreceitainternacao($internacao_id) {
        $this->db->select(' ag.ambulatorio_receituario_id,
                            ag.texto,
                            ag.medico_parecer1');
        $this->db->from('tb_ambulatorio_receituario ag');
        $this->db->where('ag.laudo_id', $internacao_id);
        $this->db->where('ag.tipo', 'NORMAL');
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

    function editarreceituario() {
        try {
            /* inicia o mapeamento no banco */
            $horario = date("Y-m-d H:i:s");
            $operador_id = $this->session->userdata('operador_id');
            $this->db->set('texto', $_POST['laudo']);
//            $this->db->set('paciente_id', $_POST['paciente_id']);
//            $this->db->set('procedimento_tuss_id', $_POST['procedimento_tuss_id']);
            $this->db->set('laudo_id', $_POST['internacao_id']);
            $this->db->set('medico_parecer1', $_POST['medico']);
            $this->db->set('data_atualizacao', $horario);
            $this->db->set('operador_atualizacao', $operador_id);
            $this->db->where('ambulatorio_receituario_id', $_POST['receituario_id']);
            $this->db->update('tb_ambulatorio_receituario');
        } catch (Exception $exc) {
            return -1;
        }
    }

    function listarreceitaimpressao($ambulatorio_laudo_id) {

        $this->db->select('ar.ambulatorio_receituario_id,
                           ar.paciente_id,
                           ar.data_cadastro,
                           ar.texto,
                           p.nome as paciente');
        $this->db->from('tb_ambulatorio_receituario ar');
        $this->db->join('tb_paciente p', 'p.paciente_id = ar.paciente_id', 'left');
        $this->db->where("ar.ambulatorio_receituario_id", $ambulatorio_laudo_id);
        $return = $this->db->get();
        return $return->result();
    }

    function atualizaleitotranferencia($leito_id, $novo_leito) {
        //setando o antigo leito para true
        $this->db->set('ativo', 'true');
        $this->db->where('internacao_leito_id', $leito_id);
        $this->db->update('tb_internacao_leito');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
        //setando o atual leito para false
        $this->db->set('ativo', 'false');
        $this->db->where('internacao_leito_id', $novo_leito);
        $this->db->update('tb_internacao_leito');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
    }

    function buscaPaciente($pacienteId) {

        $this->db->from('tb_paciente')
                ->select('nome');
        $this->db->where('paciente_id', $pacienteId);
        return $this->db;
    }

    function listar($args = array()) {
        $this->db->select(' i.internacao_id,
                            i.paciente_id,
                            i.data_solicitacao,
                            p.nome,
                            p.celular,
                            p.telefone,
                            p.nascimento,
                            i.motivo_saida,
                            i.leito,
                            c.nome as convenio,
                            iu.nome as hospital,
                            i.data_internacao');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = i.hospital', 'left');
        $this->db->join('tb_convenio c', 'c.convenio_id = p.convenio_id', 'left');
        $this->db->where('i.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', "%" . $args['nome'] . "%", 'left');
            }
            if (isset($args['hospital']) && strlen($args['hospital']) > 0) {
                $this->db->where('i.hospital', $args['hospital']);
            }
        }
        return $this->db;
    }

    function listarsaida($args = array()) {
        $this->db->select(' i.internacao_id,
                            i.paciente_id,
                            p.nome,
                            i.data_internacao,
                            i.data_saida');
        $this->db->from('tb_internacao i');
        $this->db->join('tb_paciente p', 'p.paciente_id = i.paciente_id ');
        $this->db->where('i.ativo', 'f');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('p.nome ilike', $args['nome'] . "%", 'left');
//                $this->db->orwhere('i.paciente_id', $args['nome']);
                $this->db->orwhere('p.nome', $args['nome']);
            }
        }
        return $this->db;
    }

    function listarinternacao($parametro) {
        $this->db->select('p.descricao,
                           cid.no_cid as nomecid,
                           cid.co_cid as codcid,
                           i.data_internacao,
                           o.nome as medico,
                           i.procedimentosolicitado,
                           i.estado');
        $this->db->from('tb_internacao i ');
        $this->db->join('tb_cid cid', 'cid.co_cid = i.cid1solicitado');
        $this->db->join('tb_procedimento p', 'p.procedimento = i.procedimentosolicitado');
        $this->db->join('tb_operador o', 'o.operador_id = i.medico_id');
        $this->db->where('i.ativo', 't');
        if ($parametro != null) {
            $this->db->where('paciente_id', $parametro);
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarleitosinternacao($parametro) {
        $this->db->select('io.leito_id,
                           io.data_cadastro,
                           io.operador_cadastro,
                           io.internacao_ocupacao_id,
                           il.nome as leito,
                           ie.nome as enfermaria,
                           iu.nome as unidade,
                           o.nome as operador');
        $this->db->from('tb_internacao_ocupacao io');
        $this->db->join('tb_internacao_leito il', 'il.internacao_leito_id = io.leito_id');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->join('tb_operador o', 'o.operador_id = io.operador_cadastro');
        $this->db->where('paciente_id', $parametro);
        $this->db->orderby('io.data_cadastro');
        $return = $this->db->get();
        return $return->result();
    }

    function listaleito($args = array()) {
        $this->db->select(' il.internacao_leito_id,
                            il.nome,
                            ienome as enfermaria,
                            iu.nome as unidade,
                            il.tipo');
        $this->db->from('tb_internacao_leito il');
        $this->db->join('tb_internacao_enfermaria ie', 'ie.internacao_enfermaria_id = il.enfermaria_id ');
        $this->db->join('tb_internacao_unidade iu', 'iu.internacao_unidade_id = ie.unidade_id ');
        $this->db->where('ie.ativo', 't');
        if ($args) {
            if (isset($args['nome']) && strlen($args['nome']) > 0) {
                $this->db->where('il.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('ie.nome ilike', "%" . $args['nome'] . "%");
                $this->db->orwhere('iu.nome ilike', "%" . $args['nome'] . "%");
            }
        }
        return $this->db;
    }

    function listaprocedimentoautocomplete($parametro = null) {
        $this->db->select(' codigo,
                            descricao,
                            procedimento_tuss_id');
        $this->db->from('tb_procedimento_tuss');
        if ($parametro != null) {
            $this->db->where('codigo ilike', "%" . $parametro . "%");
            $this->db->orwhere('descricao ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listarautocompletemedicamentoprescricao($parametro = null) {
        $this->db->select('farmacia_produto_id,
                           descricao');
        $this->db->from('tb_farmacia_produto');
        if ($parametro != null) {
            $this->db->where('descricao ilike', "%" . $parametro . "%");
        }
        $this->db->where('ativo', 't');
        $return = $this->db->get();
        return $return->result();
    }

    function listacidautocomplete($parametro = null) {
        $this->db->select(' co_cid,
                            no_cid');
        $this->db->from('tb_cid');
        if ($parametro != null) {
            $this->db->where('no_cid ilike', "%" . $parametro . "%");
            $this->db->orwhere('co_cid ilike', "%" . $parametro . "%");
        }
        $return = $this->db->get();
        return $return->result();
    }

    function listamedicamentointernacao($internacao_id) {
        $this->db->select(' ip.dias,
                            ip.aprasamento,
                            fp.descricao');
        $this->db->from('tb_internacao_prescricao_medicamento ip');
        $this->db->join('tb_farmacia_produto fp', 'fp.farmacia_produto_id = ip.medicamento_id');
        $this->db->where('ip.ativo', 'true');
        $this->db->where('internacao_id', $internacao_id);
        $return = $this->db->get();
        return $return->result();
    }

    function verificainternacao($paciente_id) {
        $this->db->select();
        $this->db->from('tb_internacao');
        $this->db->where("ativo", 'true');
        $this->db->where("paciente_id", $paciente_id);
        $return = $this->db->count_all_results();
        return $return;
    }

    function internacaoalta($internacao_id) {
        $this->db->set('ativo', 'false');
        $this->db->where('internacao_id', $internacao_id);
        $this->db->update('tb_internacao');
        $erro = $this->db->_error_message();
        if (trim($erro) != "") { // erro de banco
            return false;
        }
    }

}

?>
